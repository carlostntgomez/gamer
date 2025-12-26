<?php

namespace App\View\Components\Home;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TrendingProducts extends Component
{
    public $featuredProducts;

    public function __construct()
    {
        $this->featuredProducts = Product::where('is_featured', true)
                                         ->where('is_visible', true)
                                         ->inRandomOrder()
                                         ->take(8)
                                         ->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.home.trending-products');
    }
}
