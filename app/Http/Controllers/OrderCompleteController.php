<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderCompleteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Order $order)
    {
        // Cargar las relaciones necesarias, incluido el historial de estados ordenado.
        $order->load([
            'billingAddress',
            'shippingAddress',
            'orderItems.product',
            'statusHistories' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ]);

        // Devolver la vista con los datos del pedido
        return view('pages.order-complete.index', compact('order'));
    }
}
