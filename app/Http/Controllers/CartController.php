<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShippingZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartProductIds = array_keys($cart);
        $relatedProducts = Product::where('is_visible', true)->whereNotIn('id', $cartProductIds)->inRandomOrder()->take(8)->get();
        $shippingZones = ShippingZone::all();
        $municipalities = ShippingZone::select('municipality')->distinct()->get();
        return view('pages.cart.index', compact('cart', 'shippingZones', 'municipalities', 'relatedProducts'));
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'sometimes|integer|min:1', 'options' => 'sometimes|array']);
        $productId = $request->input('product_id');
        $quantity = (int)$request->input('quantity', 1);
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        $cartId = $this->generateCartId($productId, $request->input('options', []));
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $quantity;
        } else {
            $cart[$cartId] = [
                'product_id' => $productId, 
                'cart_id' => $cartId, 
                'name' => $product->name, 
                'quantity' => $quantity, 
                'price' => (float)($product->sale_price ?? $product->price), 
                'image' => $product->main_image_path, 
                'slug' => $product->slug, 
                'options' => $request->input('options', [])
            ];
        }
        session()->put('cart', $cart);
        session()->save();
        return response()->json(['success' => true, 'message' => 'Producto añadido al carrito.', 'cart_count' => $this->getCartCount(session()->get('cart', [])), 'drawer_html' => $this->getCartDrawerHtml()]);
    }

    public function update(Request $request, $rowId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart = session()->get('cart', []);
        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] = (int)$request->input('quantity');
            session()->put('cart', $cart);
            session()->save();
        }
        return response()->json(['success' => true, 'message' => 'Carrito actualizado.', 'cart_count' => $this->getCartCount(session()->get('cart', [])), 'drawer_html' => $this->getCartDrawerHtml()]);
    }

    public function destroy($rowId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);
            session()->put('cart', $cart);
            session()->save();
        }
        return response()->json(['success' => true, 'message' => 'Producto eliminado del carrito.', 'cart_count' => $this->getCartCount(session()->get('cart', [])), 'drawer_html' => $this->getCartDrawerHtml()]);
    }

    public function clear()
    {
        Session::forget('cart');
        session()->save();
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'El carrito ha sido vaciado.', 'cart_count' => 0, 'drawer_html' => $this->getCartDrawerHtml()]);
        }
        return redirect()->route('cart.index')->with('info', 'Tu carrito ha sido vaciado.');
    }

    public function getCartDrawer()
    {
        return $this->getCartDrawerHtml();
    }

    private function getCartDrawerHtml()
    {
        $cart = session()->get('cart', []);
        $cartCount = $this->getCartCount($cart);
        $subtotal = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
        return View::make('components.cart-drawer', compact('cart', 'cartCount', 'subtotal'))->render();
    }

    private function generateCartId($productId, $options = [])
    {
        if (empty($options)) {
            return $productId;
        }
        ksort($options);
        return $productId . '_' . md5(json_encode($options));
    }

    private function getCartCount($cart)
    {
        return array_reduce($cart, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }
}
