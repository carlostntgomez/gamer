<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Added this line

class PageController extends Controller
{
    public function home() { return view('home'); }
    public function aboutUs() { return view('about-us'); }
    public function contactUs() { return view('contact-us'); }
    public function loginAccount() { return view('login-account'); }
    public function createAccount() { return view('create-account'); }
    public function termsCondition() { return view('terms-condition'); }
    public function faq() { return view('faq'); }
    public function cartPage() { return view('cart-page'); }
    public function productTemplate($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product-template', compact('product'));
    }
    public function wishlistProduct() { return view('wishlist-product'); }
    public function orderHistory() { return view('order-history'); }
    public function profile() { return view('profile'); }
    public function proAddress() { return view('pro-address'); }
    public function proTickets() { return view('pro-tickets'); }
    public function billingInfo() { return view('billing-info'); }
    public function blogGridRight() { return view('blog-grid-right'); }
    public function blogGridWithout() { return view('blog-grid-without'); }
    public function blogGrid() { return view('blog-grid'); }
    public function cancellation() { return view('cancellation'); }
    public function cartEmpty() { return view('cart-empty'); }
    public function changePassword() { return view('change-password'); }
    public function checkoutStyle() { return view('checkout-style'); }
    public function collectionListWithout() { return view('collection-list-without'); }
    public function collectionWithout() { return view('collection-without'); }
    public function collection() { return view('collection'); }
    public function comingSoon() { return view('coming-soon'); }
    public function orderComplete() { return view('order-complete'); }
    public function paymentPolicy() { return view('payment-policy'); }
    public function privacyPolicy() { return view('privacy-policy'); }
    public function returnPolicy() { return view('return-policy'); }
    public function searchBlog() { return view('search-blog'); }
    public function search() { return view('search'); }
    public function shippingPolicy() { return view('shipping-policy'); }
    public function sitemap() { return view('sitemap'); }
    public function trackPage() { return view('track-page'); }
    public function wishlistEmpty() { return view('wishlist-empty'); }
    public function proWishlist() { return view('pro-wishlist'); }
    public function notFound() { return view('404'); }
    public function articlePostRight() { return view('article-post-right'); }
    public function articlePostWithout() { return view('article-post-without'); }
    public function articlePost() { return view('article-post'); }

    // New methods for newly defined routes
    public function proJuiceMachine() { return view('pro-juice-machine'); }
    public function proEarbuds() { return view('pro-earbuds'); }
    public function proPendrive() { return view('pro-pendrive'); }

    public function index2() { return view('index2'); }
    public function index3() { return view('index3'); }
    public function index4() { return view('index4'); }
    public function index5() { return view('index5'); }
    public function index6() { return view('index6'); }
    public function index7() { return view('index7'); }
    public function index8() { return view('index8'); }
    public function index9() { return view('index9'); }

    public function collectionRight() { return view('collection-right'); }
    public function collectionList() { return view('collection-list'); }
    public function collectionListRight() { return view('collection-list-right'); }

    public function blogIndex() { return view('blog-index'); }
    public function checkoutStyle1() { return view('checkout-style1'); }

    public function show($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)
                                ->where('is_published', true)
                                ->firstOrFail();

        return view('page.show', compact('page'));
    }
}
