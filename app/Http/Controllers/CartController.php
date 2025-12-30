<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        // If cart is empty then this is the first product
        if(isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->sale_price ?? $product->price,
                "image" => $product->main_image_path,
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        // Render the cart drawer view with the updated cart data
        $cartDrawerHtml = view('components.cart-drawer', ['cart' => $cart])->render();
        $cartCount = count($cart);

        return response()->json([
            'success' => true,
            'message' => '¡Producto añadido al carrito!',
            'cart_drawer_html' => $cartDrawerHtml,
            'cart_count' => $cartCount
        ]);
    }
}
