<?php

namespace App\Observers;

use App\Models\Order;

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
        $subtotal = $order->orderItems->reduce(function ($carry, $item) {
            // Ensure item and its properties exist to prevent errors
            if ($item && isset($item->quantity) && isset($item->unit_price)) {
                return $carry + ($item->quantity * $item->unit_price);
            }
            return $carry;
        }, 0);

        // Create a numeric representation of current and new totals for a reliable comparison.
        $currentTotal = (float) $order->total;
        $newTotal = (float) $subtotal;

        // Only update and save if the total has actually changed.
        if ($currentTotal !== $newTotal) {
            $order->subtotal = $newTotal;
            $order->total = $newTotal; // In the future, this could include shipping, taxes, etc.

            // Save the model without triggering the 'saved' event again, preventing an infinite loop.
            $order->saveQuietly();
        }
    }
}
