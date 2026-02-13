<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(Request $request)
    {
        $featuredProducts = Product::where('is_featured', true)
            ->where('is_visible', true)
            ->inRandomOrder()
            ->take(8)
            ->get();
            
        $newProducts = Product::where('is_visible', true)->latest()->take(10)->get();

        $banners = Banner::where('is_active', true)->get();
        $brands = Brand::where('is_visible', true)->get();
        return view('pages.home.index', compact('featuredProducts', 'newProducts', 'banners', 'brands'));
    }
}
