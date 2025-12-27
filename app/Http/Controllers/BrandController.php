<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function show(Request $request, Brand $brand)
    {
        $productQuery = $brand->products();

        if ($request->has('categories')) {
            $productQuery->whereIn('category_id', $request->get('categories'));
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $productQuery->whereBetween('price', [$request->get('min_price'), $request->get('max_price')]);
        }

        $minPrice = $productQuery->min('price');
        $maxPrice = $productQuery->max('price');

        $products = $productQuery->paginate(12);
        $allCategories = Category::withCount('products')->get();
        $allBrands = Brand::withCount('products')->get();

        return view('pages.brands.show', compact(
            'products', 
            'brand', 
            'allCategories', 
            'allBrands',
            'minPrice',
            'maxPrice'
        ));
    }
}
