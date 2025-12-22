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
                                    <a class="breadcrumb-link" href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">{{ $category->name }}</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- collection-left start -->
        <section class="main-content-wrap bg-color shop-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="pro-grli-wrap product-grid">
                            <div class="collection-img-wrap">
                                <h6 class="st-title" data-animate="animate__fadeInUp">{{ $category->name }} ({{ $products->total() }})</h6>
                                <!-- collection info start -->
                                <div class="collection-info">
                                    <div class="collection-image" data-animate="animate__fadeInUp">
                                        @if($category->banner_url)
                                            <img src="{{ $category->banner_url }}" class="img-fluid" alt="{{ $category->name }} banner">
                                        @else
                                            <img src="{{ asset('img/banner/sall-banner.jpg') }}" class="img-fluid" alt="sall-banner">
                                        @endif
                                    </div>
                                </div>
                                <!-- collection info end -->
                            </div>
                            <!-- shop-top-bar start -->
                            <div class="shop-top-bar collection">
                                <div class="product-filter" data-animate="animate__fadeInUp">
                                    <button class="filter-button" type="button"><i class="fa-solid fa-filter"></i><span>Filter</span></button>
                                </div>
                                <div class="product-view-mode">
                                    <!-- shop-item-filter-list start -->
                                    <a href="javascript:void(0)" class="list-change-view grid-three active" data-grid-view="3"><i class="fa-solid fa-border-all"></i></a>
                                    <a href="javascript:void(0)" data-grid-view="1" class="list-change-view list-one"><i class="fa-solid fa-list"></i></a>
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
                            <div class="special-product grid-3">
                                <div class="collection-category">
                                    <div class="row">
                                        <div class="col">
                                            <div class="collection-wrap">
                                                <ul class="product-view-ul">
                                                    @foreach ($products as $product)
                                                        <li class="pro-item-li animate__fadeInUp animate__animated" data-animate="animate__fadeInUp">
                                                            <div class="single-product-wrap">
                                                                <div class="product-image banner-hover">
                                                                    <a href="{{ route('product.show', $product->slug) }}" class="pro-img">
                                                                        @if(isset($product->images[0]))
                                                                            <img src="{{ Storage::url($product->images[0]) }}" class="img-fluid img1 mobile-img1" alt="{{ $product->name }}">
                                                                        @endif
                                                                        @if(isset($product->images[1]))
                                                                            <img src="{{ Storage::url($product->images[1]) }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
                                                                        @else
                                                                            @if(isset($product->images[0]))
                                                                                <img src="{{ Storage::url($product->images[0]) }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
                                                                            @endif
                                                                        @endif
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
                                                                        <a href="wishlist-product.html" class="wishlist">
                                                                            <span class="tooltip-text">Wishlist</span>
                                                                            <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="product-caption">
                                                                    <div class="product-content">
                                                                        <div class="product-sub-title">
                                                                            <span>{{ $category->name }}</span>
                                                                        </div>
                                                                        <div class="product-title">
                                                                            <h6><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></h6>
                                                                        </div>
                                                                        <div class="product-price">
                                                                            <div class="pro-price-box">
                                                                                @if($product->sale_price && $product->sale_price < $product->price)
                                                                                    <span class="new-price">${{ number_format($product->sale_price, 2) }}</span>
                                                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                                                @else
                                                                                    <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="product-description">
                                                                            <p>{{ Str::limit(strip_tags($product->description), 150) }}</p>
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
                                                                            <a href="wishlist-product.html" class="wishlist">
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
                                                                    </div>
                                                                </div>    
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="paginatoin-area">
                                                {{ $products->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Latest-product end -->
                        </div>
                        <div class="pro-grli-wrap product-sidebar">
                            <div class="pro-grid-block">
                                <div class="shop-sidebar-inner collection">
                                    <div class="shop-sidebar-wrap filter-sidebar">
                                        <!-- button start -->
                                        <button class="close-sidebar close-without" type="button">
                                        <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <!-- button end -->
                                        <!-- filter-form start -->
                                        <div class="facets">
                                            <form class="facets-form">
                                                <div class="facets-wrapper">
                                                    <!-- Product-Categories start -->
                                                    <div class="shop-sidebar">
                                                        <h6 class="shop-title">Categories</h6>
                                                        <a href="#collapse-5" data-bs-toggle="collapse" class="shop-title shop-title-lg">Categories<i class="fa fa-angle-down"></i></a>
                                                        <div class="collapse show shop-element" id="collapse-5">
                                                            <ul class="brand-ul scrollbar">
                                                                @foreach ($categories as $cat)
                                                                <li class="cat-checkbox">
                                                                    <label class="checkbox-label">
                                                                        <input type="checkbox" class="cust-checkbox" onchange="window.location.href='{{ route('category.show', $cat->slug) }}'" {{ $cat->slug == $category->slug ? 'checked' : '' }}>
                                                                        <span class="check-name">{{ $cat->name }}</span>
                                                                        <span class="count-check">({{ $cat->products_count }})</span>
                                                                        <span class="cust-check"></span>
                                                                    </label>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- filter-form end -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- collection-left end -->
    </main>
    <!-- main section end-->
</x-app-layout>
