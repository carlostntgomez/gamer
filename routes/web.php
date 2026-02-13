<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderCompleteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController; // Asegurarse de que este controlador estC importado
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Rutas con Controladores ---
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/brands/{brand:slug}', [BrandController::class, 'show'])->name('brands.show');

// --- Rutas del Modal de Vista RÁPIDA ---
// Route::get('/shop/quick-view/{product:slug}', [ProductController::class, 'quickView'])->name('product.quickView'); // ELIMINADO

// Rutas del Carrito
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::get('/cart/drawer', [CartController::class, 'getCartDrawer'])->name('cart.drawer'); // <-- Nueva ruta
Route::put('/cart/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::delete('/cart/{rowId}', [CartController::class, 'destroy'])->name('cart.remove');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/order-complete/{order}', OrderCompleteController::class)->name('order-complete.index');

// --- Ruta para las Reseñas ---
Route::post('/reviews/{product}', [ReviewController::class, 'store'])->name('reviews.store');

// --- Ruta para el formulario "Haz una pregunta" ---
Route::post('/contact/ask-question', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'question' => 'required|string|max:2000',
    ]);

    if ($validator->fails()) {
        return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
    }
    
    // Aquí se podría añadir la lógica para enviar un email de notificación.
    // Por ahora, solo devolvemos una respuesta de éxito.

    return response()->json(['success' => true, 'message' => '¡Gracias por tu pregunta! Te responderemos pronto.']);
})->name('contact.ask-question');


// --- Rutas de Vistas Estáticas ---
Route::view('/about', 'pages.about.index')->name('about.index');
Route::view('/contact', 'pages.contact.index')->name('contact.index');
Route::view('/terms-condition', 'pages.terms-condition.index')->name('terms-condition.index');
Route::view('/privacy-policy', 'pages.privacy-policy.index')->name('privacy-policy.index');
Route::view('/shipping-policy', 'pages.shipping-policy.index')->name('shipping-policy.index');
Route::view('/payment-policy', 'pages.payment-policy.index')->name('payment-policy.index');
Route::view('/return-policy', 'pages.return-policy.index')->name('return-policy.index');
Route::view('/faq', 'pages.faq.index')->name('faq.index');
