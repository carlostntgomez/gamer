<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReviewController; // <--- AÑADIDO

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/product/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

// Blog Post Routes
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

// Review Route (Nested within Product)
Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store'); // <--- AÑADIDO

// Static Pages
Route::view('/about-us', 'pages.about.index')->name('about');
Route::view('/contact', 'pages.contact.index')->name('contact');
Route::view('/faq', 'pages.faq.index')->name('faq');
Route::view('/payment-policy', 'pages.payment-policy.index')->name('payment-policy');
Route::view('/privacy-policy', 'pages.privacy-policy.index')->name('privacy-policy');
Route::view('/return-policy', 'pages.return-policy.index')->name('return-policy');
Route::view('/shipping-policy', 'pages.shipping-policy.index')->name('shipping-policy');
Route::view('/terms-condition', 'pages.terms-condition.index')->name('terms-condition');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/mapa-del-sitio', function () {
    return view('pages.sitemap.index');
})->name('sitemap');

// Category Route
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Brand Route
Route::get('/brand/{brand:slug}', [BrandController::class, 'show'])->name('brands.show');

// Cart Routes
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
