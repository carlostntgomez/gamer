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

Route::get('/sobre-nosotros', function () {
    return view('pages.about.index');
})->name('about');

Route::get('/contacto', function () {
    return view('pages.contact.index');
})->name('contact');

Route::get('/faq', function () {
    return view('pages.faq.index');
})->name('faq');

Route::get('/politicas-de-pago', function () {
    return view('pages.payment-policy.index');
})->name('payment-policy');

Route::get('/politica-de-privacidad', function () {
    return view('pages.privacy-policy.index');
})->name('privacy-policy');

Route::get('/politica-de-devoluciones', function () {
    return view('pages.return-policy.index');
})->name('return-policy');

Route::get('/politica-de-envios', function () {
    return view('pages.shipping-policy.index');
})->name('shipping-policy');

Route::get('/terminos-y-condiciones', function () {
    return view('pages.terms-condition.index');
})->name('terms-condition');
