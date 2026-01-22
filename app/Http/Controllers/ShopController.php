<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_visible', true)->paginate(12);
        return view('pages.shop.index', compact('products'));
    }

    public function search(Request $request)
    {
        // La lógica de búsqueda puede implementarse aquí en el futuro
        return redirect()->route('shop.index');
    }

    public function show(Product $product)
    {
        // Asegurarse de que el producto sea visible antes de mostrarlo
        if (!$product->is_visible) {
            abort(404);
        }

        // Carga eficiente de relaciones para evitar N+1 queries.
        $product->load(['categories', 'brand', 'reviews.user']);

        // Inicializar colecciones para los carruseles de productos
        $additional_products = collect();
        $related_products = collect();

        // Obtener la primera categoría del producto para determinar las relaciones
        $firstCategory = $product->categories->first();

        if ($firstCategory) {
            // --- Lógica para Productos Adicionales (de la misma categoría PADRE) ---
            // Muestra productos de una categoría más amplia y relacionada.
            if ($firstCategory->parent_id) {
                $additional_products = Product::where('is_visible', true)
                    ->whereHas('categories', function ($query) use ($firstCategory) {
                        $query->where('parent_id', $firstCategory->parent_id);
                    })
                    ->where('id', '!=', $product->id) // Excluir el producto actual
                    ->inRandomOrder()
                    ->take(10)
                    ->get();
            }

            // --- Lógica para Productos Relacionados (de la misma categoría EXACTA) ---
            // Muestra productos que son alternativas directas.
            $related_products = Product::where('is_visible', true)
                ->whereHas('categories', function ($query) use ($firstCategory) {
                    $query->where('id', $firstCategory->id);
                })
                ->where('id', '!=', $product->id) // Excluir el producto actual
                ->whereNotIn('id', $additional_products->pluck('id')->all()) // No mostrar productos que ya están en la sección "adicional"
                ->inRandomOrder()
                ->take(10)
                ->get();
        }

        // Pasar todos los datos a la vista
        return view('pages.shop.show', compact('product', 'additional_products', 'related_products'));
    }
}
