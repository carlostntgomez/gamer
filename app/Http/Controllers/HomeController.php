<?php

namespace App\Http\Controllers;

use App\Models\Banner;
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
            
        $banners = Banner::all();
        return view('pages.home.index', compact('featuredProducts', 'banners'));
    }
}
