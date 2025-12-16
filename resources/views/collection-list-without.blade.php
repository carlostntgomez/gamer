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
                                    <span class="breadcrumb-text">Collection list</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- collection-list start -->
        <section class="main-content-wrap bg-color shop-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="pro-grli-wrap product-grid">
                            <div class="collection-img-wrap">
                                <h6 class="st-title" data-animate="animate__fadeInUp">Collection list (23)</h6>
                                <!-- collection info start -->
                                <div class="collection-info">
                                    <div class="collection-image" data-animate="animate__fadeInUp">
                                        <img src="{{ asset('img/banner/sall-banner.jpg') }}" class="img-fluid" alt="sall-banner">
                                    </div>
                                </div>
                                <!-- collection info end -->
                            </div>
                            <!-- shop-top-bar start -->
                            <div class="shop-top-bar collection">
                                <div class="product-filter without-sidebar">
                                    <button class="filter-button" type="button"><i class="fa-solid fa-filter"></i><span>Filter</span></button>
                                </div>
                                <div class="product-view-mode">
                                    <!-- shop-item-filter-list start -->
                                    <a href="javascript:void(0)" class="list-change-view grid-three" data-grid-view="3"><i class="fa-solid fa-border-all"></i></a>
                                    <a href="javascript:void(0)" class="list-change-view list-one active" data-grid-view="1"><i class="fa-solid fa-list"></i></a>
                                    <!-- shop-item-filter-list end -->
                                </div>
                                <!-- product-short start -->
                                <div class="product-short">
                                    <label for="SortBy">Sort by:</label>
                                    <select class="nice-select" name="sortby" id="SortBy">
                                        <option value="manual">Featured</option>
                                        <option value="best-selling">Best Selling</option>
                                        <option value="title-ascending">Alphabetically, A-Z</option>
                                        <option value="title-descending">Alphabetically, Z-A</option>
                                        <option value="price-ascending">Price, low to high</option>
                                        <option value="price-descending">Price, high to low</option>
                                        <option value="created-descending">Date, new to old</option>
                                        <option value="created-ascending">Date, old to new</option>
                                    </select>
                                    <a href="javascript:void(0)" class="short-title">
                                        <span class="sort-title">Best Selling</span>
                                        <span class="sort-icon"><i class="bi bi-chevron-down"></i></span>
                                    </a>
                                    <a href="javascript:void(0)" class="short-title short-title-lg">
                                        <span class="sort-title">Best Selling</span>
                                        <span class="sort-icon"><i class="bi bi-chevron-down"></i></span>
                                    </a>
                                    <ul class="pro-ul collapse" id="select-wrap">
                                        <li class="pro-li"><a href="javascript:void(0)">Featured</a></li>
                                        <li class="pro-li selected"><a href="javascript:void(0)">Best Selling</a></li>
                                        <li class="pro-li"><a href="javascript:void(0)">Alphabetically, A-Z</a></li>
                                        <li class="pro-li"><a href="javascript:void(0)">Alphabetically, Z-A</a></li>
                                        <li class="pro-li"><a href="javascript:void(0)">Price, low to high</a></li>
                                        <li class="pro-li"><a href="javascript:void(0)">Price, high to low</a></li>
                                        <li class="pro-li"><a href="javascript:void(0)">Date, new to old</a></li>
                                        <li class="pro-li"><a href="javascript:void(0)">Date, old to new</a></li>
                                    </ul>
                                </div>
                                <!-- product-short end -->
                            </div>
                            <!-- shop-top-bar end -->
                            <!-- Latest-product start -->  
                            <div class="special-product grid-1">
                                <div class="collection-category">
                                    <div class="row">
                                        <div class="col">
                                            <div class="collection-wrap">
                                                <ul class="product-view-ul">
                                                    <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                        <div class="single-product-wrap">
                                                            <div class="product-image banner-hover">
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
                                                            <div class="product-caption">
                                                                <div class="product-content">
                                                                    <div class="product-sub-title">
                                                                        <span>Wireless device</span>
                                                                    </div>
                                                                    <div class="product-title">
                                                                        <h6><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Wireless headphones</a></h6>
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
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Latest-product end -->
                        </div>
                    </div>
                </div>
            </section>
            <!-- collection-list end -->
    </main>
</x-app-layout>