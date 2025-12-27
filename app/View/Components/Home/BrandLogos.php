<?php

namespace App\View\Components\Home;

use App\Models\Brand;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class BrandLogos extends Component
{
    public Collection $brands;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Cache the query for better performance
        $this->brands = Cache::remember('home_brand_logos', now()->addHour(), function () {
            return Brand::whereNotNull('logo_path')
                        ->orderBy('name', 'asc')
                        ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.brand-logos');
    }
}
