<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, Category $category)
    {
        $productQuery = $category->products();

        if ($request->has('brands')) {
            $productQuery->whereIn('brand_id', $request->get('brands'));
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $productQuery->whereBetween('price', [$request->get('min_price'), $request->get('max_price')]);
        }

        $minPrice = $productQuery->min('price');
        $maxPrice = $productQuery->max('price');

        $products = $productQuery->paginate(12);
        $allCategories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('pages.categories.index', compact(
            'products', 
            'category', 
            'allCategories', 
            'brands',
            'minPrice',
            'maxPrice'
        ));
    }
}
