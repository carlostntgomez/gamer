<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Product $product)
    {
        // 1. Validar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Necesitas iniciar sesión para dejar una reseña.');
        }

        // 2. Validar los datos del formulario
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:1000', // Corregido de 'comment' a 'content'
        ]);

        // 3. Verificar que el usuario no haya reseñado este producto antes
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('product_id', $product->id)
                                ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Ya has dejado una reseña para este producto.');
        }

        // 4. Crear la reseña
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'content' => $request->content, // Corregido de 'comment' a 'content'
            'is_approved' => true, // O false si quieres moderación manual
        ]);

        // 5. Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', '¡Gracias por tu reseña! Ha sido enviada.');
    }
}
