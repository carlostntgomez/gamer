<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShopController;
use App\Models\Banner;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $banners = \App\Models\Banner::where('is_active', true)->orderBy('order', 'asc')->get();

    // Get featured products
    $featuredProducts = Product::where('is_featured', true)
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('pages.home.index', compact('banners', 'featuredProducts'));
})->name('home');

// Rutas de la Tienda
Route::prefix('tienda')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/buscar', [ShopController::class, 'search'])->name('search');
    Route::get('/{product:slug}', [ShopController::class, 'show'])->name('show');
});

Route::get("/categorias/{category}", [CategoryController::class, "show"])->name("categories.show");

Route::get("/posts", [PostController::class, "index"])->name("posts.index");
Route::get("/posts/search", [PostController::class, "search"])->name("posts.search");
Route::get("/posts/{post}", [PostController::class, "show"])->name("posts.show");

Route::get('marcas/{brand:slug}', [BrandController::class, 'show'])->name('brands.show');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
