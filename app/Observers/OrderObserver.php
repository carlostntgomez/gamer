<?php

namespace App\Observers;

use App\Models\Order;
// use Illuminate\Support\Facades\Log; // Uncomment if Log is needed elsewhere

class OrderObserver
{
    /**
     * Handle the Order "saved" event.
     *
     * This method is triggered after an order and its related items are saved.
     * It recalculates the subtotal and total from the order items to ensure
     * financial data integrity, regardless of frontend calculations.
     */
    public function saved(Order $order): void
    {
        // Recalculate subtotal from the persisted order items
        // $recalculatedSubtotal = $order->orderItems->reduce(function ($carry, $item) {
        //     // Ensure item and its properties exist to prevent errors
        //     // Usar $item->price en lugar de $item->unit_price, consistente con OrderItem model
        //     if ($item && isset($item->quantity) && isset($item->price)) {
        //         return $carry + ($item->quantity * $item->price);
        //     }
        //     return $carry;
        // }, 0);

        // // Calculate the full new total including shipping cost
        // $recalculatedTotal = $recalculatedSubtotal + $order->shipping_cost; // AHORA INCLUYE EL COSTO DE ENVÍO

        // // Create a numeric representation of current and new totals for a reliable comparison.
        // $currentSubtotal = (float) $order->subtotal;
        // $currentTotal = (float) $order->total;

        // // Only update and save if the subtotal or total has actually changed.
        // // Comparar con una pequeña tolerancia para flotantes
        // $tolerance = 0.0001; // Para evitar problemas de precisión con flotantes

        // if (abs($currentSubtotal - $recalculatedSubtotal) > $tolerance || abs($currentTotal - $recalculatedTotal) > $tolerance) {
        //     $order->subtotal = $recalculatedSubtotal;
        //     $order->total = $recalculatedTotal;

        //     // Save the model without triggering the 'saved' event again, preventing an infinite loop.
        //     $order->saveQuietly();
        // }
    }
}