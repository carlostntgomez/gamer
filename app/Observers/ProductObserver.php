<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\DealOfTheDay;
// use App\Models\NewArrival;

class ProductObserver
{
    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        // Find and delete related models
        DealOfTheDay::where('product_id', $product->id)->delete();
        // NewArrival::where('product_id', $product->id)->delete();
    }
}
