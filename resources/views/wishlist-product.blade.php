<x-app-layout>
    <!-- main section start-->
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="col">
                    <div class="row">
                        <div class="breadcrumb-index">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">wishlist</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- wishlist-product start -->
        <section class="wishlist-product section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <!-- wishlist-page start -->
                        <div class="wishlist-page">
                            <div class="wishlist-area">
                                <div class="wishlist-details">
                                    <div class="wishlist-item" data-animate="animate__fadeInUp">
                                        <span class="wishlist-head">My wishlist:</span>
                                        <span class="sp-link-title">5 Item</span>
                                    </div>
                                    <div class="wishlist-all-pro">
                                        <div class="wishlist-pro">
                                            <div class="wishlist-pro-image">
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                    <img src="{{ asset('img/menu/home-pro-banner1.jpg') }}" class="img-fluid" alt="p-1">
                                                </a>
                                            </div>
                                            <div class="pro-details">
                                                <h6>
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Portable speaker</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="qty-item">
                                            <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                            <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                        </div>
                                        <div class="all-pro-price">
                                            <div class="price-box" data-animate="animate__fadeInUp">
                                                <span class="new-price">$21.00</span>
                                                <span class="old-price">$25.00</span>
                                            </div>
                                            <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wishlist-area">
                                <div class="wishlist-details">
                                    <div class="wishlist-all-pro">
                                        <div class="wishlist-pro">
                                            <div class="wishlist-pro-image">
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                    <img src="{{ asset('img/menu/home-pro-banner2.jpg') }}" class="img-fluid" alt="p-2">
                                                </a>
                                            </div>
                                            <div class="pro-details">
                                                <h6>
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Air conditioner</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="qty-item">
                                            <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                            <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                        </div>
                                        <div class="all-pro-price">
                                            <div class="price-box" data-animate="animate__fadeInUp">
                                                <span class="new-price">$54.00</span>
                                                <span class="old-price">$65.00</span>
                                            </div>
                                            <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wishlist-area">
                                <div class="wishlist-details">
                                    <div class="wishlist-all-pro">
                                        <div class="wishlist-pro">
                                            <div class="wishlist-pro-image">
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                    <img src="{{ asset('img/menu/home-pro-banner3.jpg') }}" class="img-fluid" alt="p-3">
                                                </a>
                                            </div>
                                            <div class="pro-details">
                                                <h6>
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Ev charging plug</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="qty-item">
                                            <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                            <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                        </div>
                                        <div class="all-pro-price">
                                            <div class="price-box" data-animate="animate__fadeInUp">
                                                <span class="new-price">$21.00</span>
                                                <span class="old-price">$45.00</span>
                                            </div>
                                            <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wishlist-area">
                                <div class="wishlist-details">
                                    <div class="wishlist-all-pro">
                                        <div class="wishlist-pro">
                                            <div class="wishlist-pro-image">
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                    <img src="{{ asset('img/menu/home-pro-banner4.jpg') }}" class="img-fluid" alt="p-4">
                                                </a>
                                            </div>
                                            <div class="pro-details">
                                                <h6>
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Video shoot drone</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="qty-item">
                                            <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                            <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                        </div>
                                        <div class="all-pro-price">
                                            <div class="price-box" data-animate="animate__fadeInUp">
                                                <span class="new-price">$24.00</span>
                                                <span class="old-price">$29.00</span>
                                            </div>
                                            <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="wishlist-area">
                                <div class="wishlist-details">
                                    <div class="wishlist-all-pro">
                                        <div class="wishlist-pro">
                                            <div class="wishlist-pro-image">
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">
                                                    <img src="{{ asset('img/menu/home-pro-banner5.jpg') }}" class="img-fluid" alt="p-5">
                                                </a>
                                            </div>
                                            <div class="pro-details">
                                                <h6>
                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" data-animate="animate__fadeInUp">Verse earphones</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="qty-item">
                                            <a href="{{ route('cart.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Add to cart</a>
                                            <a href="{{ route('checkout.index') }}" class="add-wishlist" data-animate="animate__fadeInUp">Buy now</a>
                                        </div>
                                        <div class="all-pro-price">
                                            <div class="price-box" data-animate="animate__fadeInUp">
                                                <span class="new-price">$24.00</span>
                                                <span class="old-price">$50.00</span>
                                            </div>
                                            <span class="wishalist-icon" data-animate="animate__fadeInUp"><i class="fa fa-heart text-danger"></i></span>
                                        </div>
                                    </div>
                                    <div class="other-link">
                                        <ul class="other-ul">
                                            <li class="wishlist-other-link" data-animate="animate__fadeInUp">
                                                <a href="{{ route('collection.index') }}" class="btn btn-style2">Continue shopping</a>
                                            </li>
                                            <li class="wishlist-other-link" data-animate="animate__fadeInUp">
                                                <a href="{{ route('wishlist.empty') }}" class="btn btn-style2">Clear wishlist</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- wishlist-page end -->
                    </div>
                </div>
            </div>
        </section>
        <!-- wishlist-product end -->
    </main>
</x-app-layout>