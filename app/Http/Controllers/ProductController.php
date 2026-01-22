<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Devuelve los datos de un producto para ser mostrados en un modal de vista r\u00e1pida.
     * La vista parcial que se devuelve contiene el HTML necesario para el modal.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function quickView(Product $product)
    {
        // Cargamos la relaci\u00f3n 'brand' para poder mostrar el nombre de la marca
        // sin causar consultas N+1 a la base de datos.
        $product->load('brand');
        
        // Devolver una vista parcial (un fragmento de HTML)
        // Pasamos el producto a esta vista para que pueda renderizar los detalles.
        return view('components.product-quick-view-content', ['product' => $product]);
    }
}
