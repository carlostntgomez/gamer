<?php

namespace App\View\Components\Home;

use App\Models\Offer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;

class Offers extends Component
{
    public $offers;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Cache the result for 1 hour to avoid unnecessary database queries
        $this->offers = Cache::remember('home_offers', 3600, function () {
            return Offer::where('is_active', true)
                ->latest()
                ->take(2)
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.offers');
    }
}
