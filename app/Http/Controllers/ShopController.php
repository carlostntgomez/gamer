<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Muestra la página principal de la tienda con todos los productos.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $products = Product::with('brand')->paginate(12);

        return view('pages.shop.index', compact('products'));
    }

    /**
     * Busca productos en la base de datos y muestra los resultados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('short_description', 'like', "%{$query}%")
            ->with('brand')
            ->paginate(12);

        return view('pages.shop.search', compact('products', 'query'));
    }

    /**
     * Muestra la página de un producto específico.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Product $product)
    {
        // Carga el producto con sus relaciones para optimizar las consultas a la base de datos (Eager Loading).
        $product->load([
            'brand',
            'categories',
            'reviews' => function ($query) {
                $query->latest();
            },
            'reviews.user'
        ]);

        // Obtener productos relacionados (de la misma categoría)
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
            $query->whereIn('id', $product->categories->pluck('id'));
        })
        ->where('id', '!=', $product->id) // Excluir el producto actual
        ->take(8) // Limitar a 8 productos
        ->get();

        return view('pages.shop.show', compact('product', 'relatedProducts'));
    }
}
