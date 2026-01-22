<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        // 1. Definir reglas de validación
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ];

        // Añadir reglas para invitados
        if (Auth::guest()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email|max:255';
        }

        // 2. Validar los datos del formulario
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        // 3. Verificar que el usuario/invitado no haya reseñado este producto antes
        $existingReviewQuery = Review::where('product_id', $product->id);

        if (Auth::check()) {
            $existingReviewQuery->where('user_id', Auth::id());
        } else {
            $existingReviewQuery->where('guest_email', $request->guest_email);
        }

        if ($existingReviewQuery->exists()) {
            return redirect()->back()->with('error', 'Ya has dejado una reseña para este producto.')->withInput();
        }

        // 4. Crear la reseña
        $reviewData = [
            'product_id' => $product->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_approved' => true, // O false si quieres moderación manual
        ];

        if (Auth::check()) {
            $reviewData['user_id'] = Auth::id();
        } else {
            $reviewData['guest_name'] = $request->guest_name;
            $reviewData['guest_email'] = $request->guest_email;
        }

        Review::create($reviewData);

        // 5. Redireccionar con un mensaje de éxito
        return redirect()->back()->with('success', '¡Gracias por tu reseña! Ha sido enviada.');
    }
}
