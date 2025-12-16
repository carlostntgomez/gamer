<x-app-layout>
    <!-- main section start-->
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
                                    <span class="breadcrumb-text">Your shopping cart empty</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <section class="cart-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="empty-cart-page">
                            <div class="section-capture">
                                <div class="section-title">
                                    <h2 data-animate="animate__fadeInUp"><span>Cart empty</span></h2>
                                    <p data-animate="animate__fadeInUp">Sorry your cart has currently no more products, click on 'here' given below for continue browsing.</p>
                                    <p data-animate="animate__fadeInUp">Continue browsing
                                        <a href="{{ route('collection.index') }}">here</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- product-tranding start -->
        <section class="Trending-product bg-color section-ptb">
            <div class="collection-category">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="section-capture">
                                <div class="section-title">
                                    <span class="sub-title" data-animate="animate__fadeInUp">Browse collection</span>
                                    <h2><span data-animate="animate__fadeInUp">Trending product</span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="collection-wrap">
                                <div class="collection-slider swiper" id="Trending-product">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide" data-animate="animate__fadeInUp">
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
                                                        <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Wireless headphones</a></h6>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product-tranding end -->
    </main>
</x-app-layout>