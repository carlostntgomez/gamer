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
        // Get the latest 2 active offers directly from the database
        $this->offers = Offer::where('is_active', true)
            ->latest()
            ->take(2)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.offers');
    }
}
