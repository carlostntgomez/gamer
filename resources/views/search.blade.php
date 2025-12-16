<x-app-layout>
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb-index">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">a</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- search section start -->
        <section class="search-page bg-color section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Your search for "a" revealed the following:</span></h2>
                            </div>
                        </div>
                        <div class="saerch-input" data-animate="animate__fadeInUp">
                            <form action="{{ route('search.index') }}">
                                <input type="text" name="search" placeholder="Search our store">
                                <a href="{{ route('search.index') }}" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></a>
                            </form>
                        </div>
                        <!-- special-product start -->
                        <div class="special-product grid-3">
                            <div class="collection-category">
                                <div class="row">
                                    <div class="col">
                                        <div class="collection-wrap">
                                            <ul class="product-view-ul">
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-1.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-2.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Wireless device</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Bluetooth earbuds</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$21.00</span>
                                                                    <span class="old-price">$25.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>20%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-3.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-4.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Waterproof plyer</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Portable speaker</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$18.00</span>
                                                                    <span class="old-price">$24.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>14%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-5.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-6.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>360 Dg Rotation</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Video shoot drone</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$10.00</span>
                                                                    <span class="old-price">$15.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>22%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-7.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-8.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Avone music</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Wireless headphones</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$32.00</span>
                                                                    <span class="old-price">$38.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>30%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-9.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-10.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Softness music</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Verse earphones</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$08.00</span>
                                                                    <span class="old-price">$10.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>20%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-11.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-12.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Rotation camera</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Wifro wi-fi camera</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$32.00</span>
                                                                    <span class="old-price">$39.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>14%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-13.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-14.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Face hair removal</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Stylish for trimmer</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$44.00</span>
                                                                    <span class="old-price">$48.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>22%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                    <div class="single-product-wrap">
                                                        <div class="product-image">
                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                <img src="{{ asset('img/product/home1-pro-15.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                <img src="{{ asset('img/product/home1-pro-16.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                            </a>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="product-content">
                                                            <div class="product-sub-title">
                                                                <span>Live program</span>
                                                            </div>
                                                            <div class="product-title">
                                                                <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Movie projector S8</a></h6>
                                                            </div>
                                                            <div class="product-price">
                                                                <div class="pro-price-box">
                                                                    <span class="new-price">$55.00</span>
                                                                    <span class="old-price">$58.00</span>
                                                                </div>
                                                            </div>
                                                            <div class="product-description">
                                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                                            </div>
                                                            <div class="product-action">
                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                    <span class="tooltip-text">Quickview</span>
                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                </a>
                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                    <span class="tooltip-text">Add to cart</span>
                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                </a>
                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                    <span class="tooltip-text">Wishlist</span>
                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="pro-label-retting">
                                                            <div class="product-ratting">
                                                                <span class="pro-ratting">
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                </span>
                                                            </div>
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Sale<span>30%</span></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="paginatoin-area">
                                            <ul class="pagination-page-box" data-animate="animate__fadeInUp">
                                                <li class="number active"><a href="javascript:void(0)" class="theme-glink">1</a></li>
                                                <li class="number"><a href="javascript:void(0)" class="gradient-text">2</a></li>
                                                <li class="page-next"><a href="javascript:void(0)" class="theme-glink"><i class="fa -solid fa-angle-right"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- special-product end -->
                    </div>
                </div>
            </div>
        </section>
        <!-- search section end -->
    </main>
    <!-- main section end-->
</x-app-layout>
