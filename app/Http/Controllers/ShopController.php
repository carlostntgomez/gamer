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
        // Esto es crucial para evitar el problema de N+1 queries y mejorar el rendimiento de la página.
        $product->load([
            'brand',
            'categories',
            'reviews' => function ($query) {
                // Ordena las reseñas de la más reciente a la más antigua.
                $query->latest();
            },
            // Carga también el usuario que escribió cada reseña para poder mostrar su nombre.
            'reviews.user'
        ]);

        return view('pages.shop.show', compact('product'));
    }
}
