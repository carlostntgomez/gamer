<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Providers\Filament\AdminPanelProvider;

Route::group(['middleware' => 'web'], function () {
    Route::post('admin/login', [\Filament\Http\Livewire\Auth\Login::class, 'authenticate'])->name('filament.admin.auth.login.post');
});

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('page.about_us');
Route::get('/contact-us', [PageController::class, 'contactUs'])->name('page.contact_us');
Route::get('/login-account', [PageController::class, 'loginAccount'])->name('auth.login');
Route::get('/create-account', [PageController::class, 'createAccount'])->name('auth.register');
Route::get('/terms-condition', [PageController::class, 'termsCondition'])->name('page.terms_condition');
Route::get('/faq', [PageController::class, 'faq'])->name('page.faq');
Route::get('/cart-page', [PageController::class, 'cartPage'])->name('cart.index');
Route::get('/product/{slug}', [PageController::class, 'productTemplate'])->name('product.show');
Route::get('/wishlist-product', [PageController::class, 'wishlistProduct'])->name('wishlist.index');
Route::get('/order-history', [PageController::class, 'orderHistory'])->name('account.orders');
Route::get('/profile', [PageController::class, 'profile'])->name('account.profile');
Route::get('/pro-address', [PageController::class, 'proAddress'])->name('account.addresses');
Route::get('/pro-tickets', [PageController::class, 'proTickets'])->name('account.tickets');
Route::get('/billing-info', [PageController::class, 'billingInfo'])->name('account.billing');
Route::get('/blog-grid-right', [PageController::class, 'blogGridRight'])->name('blog.grid.right');
Route::get('/blog-grid-without', [PageController::class, 'blogGridWithout'])->name('blog.grid.without');
Route::get('/blog-grid', [PageController::class, 'blogGrid'])->name('blog.grid.index');
Route::get('/cancellation', [PageController::class, 'cancellation'])->name('page.cancellation');
Route::get('/cart-empty', [PageController::class, 'cartEmpty'])->name('cart.empty');
Route::get('/change-password', [PageController::class, 'changePassword'])->name('account.password.edit');
Route::get('/checkout-style', [PageController::class, 'checkoutStyle'])->name('checkout.index');
Route::get('/collection-list-without', [PageController::class, 'collectionListWithout'])->name('collection.list.without');
Route::get('/collection-without', [PageController::class, 'collectionWithout'])->name('collection.without');
Route::get('/collection', [PageController::class, 'collection'])->name('collection.index');
Route::get('/coming-soon', [PageController::class, 'comingSoon'])->name('page.coming_soon');
Route::get('/order-complete', [PageController::class, 'orderComplete'])->name('checkout.complete');
Route::get('/payment-policy', [PageController::class, 'paymentPolicy'])->name('page.payment_policy');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('page.privacy_policy');
Route::get('/return-policy', [PageController::class, 'returnPolicy'])->name('page.return_policy');
Route::get('/search-blog', [PageController::class, 'searchBlog'])->name('blog.search');
Route::get('/search', [PageController::class, 'search'])->name('search.index');
Route::get('/shipping-policy', [PageController::class, 'shippingPolicy'])->name('page.shipping_policy');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('page.sitemap');
Route::get('/track-page', [PageController::class, 'trackPage'])->name('order.track');
Route::get('/wishlist-empty', [PageController::class, 'wishlistEmpty'])->name('wishlist.empty');
Route::get('/pro-wishlist', [PageController::class, 'proWishlist'])->name('wishlist.pro');
Route::get('/404', [PageController::class, 'notFound'])->name('page.404');
Route::get('/article-post-right', [PageController::class, 'articlePostRight'])->name('blog.article.right');
Route::get('/article-post-without', [PageController::class, 'articlePostWithout'])->name('blog.article.without');
Route::get('/article-post', [PageController::class, 'articlePost'])->name('blog.article.show');
Route::get('/category/{slug}', [PageController::class, 'category'])->name('category.show');

// New Routes added by Gemini

// Product Category/Landing Pages
Route::get('/pro-juice-machine', [PageController::class, 'proJuiceMachine'])->name('product.category.juice_machine');
Route::get('/pro-earbuds', [PageController::class, 'proEarbuds'])->name('product.category.earbuds');
Route::get('/pro-pendrive', [PageController::class, 'proPendrive'])->name('product.category.pendrive');

// Home page variations
Route::get('/index2', [PageController::class, 'index2'])->name('home.variation.2');
Route::get('/index3', [PageController::class, 'index3'])->name('home.variation.3');
Route::get('/index4', [PageController::class, 'index4'])->name('home.variation.4');
Route::get('/index5', [PageController::class, 'index5'])->name('home.variation.5');
Route::get('/index6', [PageController::class, 'index6'])->name('home.variation.6');
Route::get('/index7', [PageController::class, 'index7'])->name('home.variation.7');
Route::get('/index8', [PageController::class, 'index8'])->name('home.variation.8');
Route::get('/index9', [PageController::class, 'index9'])->name('home.variation.9');

// Collection variations
Route::get('/collection-right', [PageController::class, 'collectionRight'])->name('collection.right');
Route::get('/collection-list', [PageController::class, 'collectionList'])->name('collection.list');
Route::get('/collection-list-right', [PageController::class, 'collectionListRight'])->name('collection.list.right');

// Generic Blog route
Route::get('/blog', [PageController::class, 'blogIndex'])->name('blog.index');
Route::get('/blog/{slug}', [PageController::class, 'showPost'])->name('blog.show');

// Checkout variation
Route::get('/checkout-style1', [PageController::class, 'checkoutStyle1'])->name('checkout.style1');

// Generic page viewer route (should be at the end to avoid catching other routes)
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '^(?!admin).*$')->name('page.show');
