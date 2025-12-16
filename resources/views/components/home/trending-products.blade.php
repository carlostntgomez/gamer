            <!-- product-tab start -->
            <section class="product-tab section-pt">
                <div class="collection-category">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="section-capture tab">
                                    <div class="section-title">
                                        <div class="section-cont-title">
                                            <h2  data-animate="animate__fadeInUp"><span>Trending product</span></h2>
                                        </div>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item" data-animate="animate__fadeInUp">
                                            <a href="#new-tab" class="nav-link active" data-bs-toggle="tab"><span>Earphone</span></a>
                                        </li>
                                        <li class="nav-item" data-animate="animate__fadeInUp">
                                            <a href="#feature-tab" class="nav-link" data-bs-toggle="tab"><span>Projector</span></a>
                                        </li>
                                        <li class="nav-item" data-animate="animate__fadeInUp">
                                            <a href="#best-tab" class="nav-link" data-bs-toggle="tab"><span>Smartphone</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="collection-wrap">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="new-tab">
                                            <div class="collection-slider swiper" id="new-product8">
                                                <div class="swiper-wrapper">
                                                    <div class="swiper-slide" data-animate="animate__fadeInUp">
                                                        <div class="single-product-wrap">
                                                            <div class="product-image banner-hover">
                                                                <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="pro-img">
                                                                    <img src="{{ asset('img/product/home8-p1.jpg') }}" class="img-fluid img1 mobile-img1" alt="p1">
                                                                    <img src="{{ asset('img/product/home8-p2.jpg') }}" class="img-fluid img2 mobile-img2" alt="p2">
                                                                </a>
                                                                <div class="product-label pro-new-sale">
                                                                    <span class="product-label-title">New</span>
                                                                </div>
                                                                <div class="product-action">
                                                                    <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                        <span class="tooltip-text">Quickview</span>
                                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                                                                    </a>
                                                                    <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                        <span class="tooltip-text">Wishlist</span>
                                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span>
                                                                    </a>
                                                                </div>
                                                                <div class="product-add-cart">
                                                                    <a href="javascript:void(0)" class="add-to-cart ajax-spin-cart">
                                                                        <span class="cart-title">+Add to cart</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="product-content">
                                                                <div class="product-title">
                                                                    <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Drone camera</a></h6>
                                                                </div>
                                                                <div class="product-price">
                                                                    <div class="pro-price-box">
                                                                        <span class="new-price">$80,000</span>
                                                                        <span class="old-price">$95,599</span>
                                                                    </div>
                                                                </div>
                                                                <div class="product-description">
                                                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type</p>
                                                                </div>
                                                                <div class="product-ratting">
                                                                    <span class="pro-ratting">
                                                                        <i class="fa-regular fa-star"></i>
                                                                        <i class="fa-regular fa-star"></i>
                                                                        <i class="fa-regular fa-star"></i>
                                                                        <i class="fa-regular fa-star"></i>
                                                                        <i class="fa-regular fa-star"></i>
                                                                    </span>
                                                                </div>
                                                                <div class="product-action">
                                                                    <a href="javascript:void(0)" class="add-to-cart">
                                                                        <span class="tooltip-text">Add to cart</span>
                                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                                                                    </a>
                                                                    <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                        <span class="tooltip-text">Quickview</span>
                                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                                                                    </a>
                                                                    <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                        <span class="tooltip-text">Wishlist</span>
                                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collection-button" data-animate="animate__fadeInUp">
                                                    <a href="{{ route('collection.index') }}" class="btn btn-style3">See more</a>
                                                </div>
                                            </div>
                                            <div class="swiper-buttons">
                                                <div class="swiper-buttons-wrap">
                                                    <button class="swiper-prev swiper-prev-new8"><span><i class="fa-solid fa-arrow-left"></i></span></button>
                                                    <button class="swiper-next swiper-next-new8"><span><i class="fa-solid fa-arrow-right"></i></span></button>
                                                </div>
                                            </div>
                                            <div class="swiper-dots">
                                                <div class="swiper-pagination swiper-pagination-new8"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product-tab end -->