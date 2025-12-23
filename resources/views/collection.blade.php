blade
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
                                    <span class="breadcrumb-text">Colección</span>
                                </li>
                                @isset($query)
                                    <li class="breadcrumb-li">
                                        <span class="breadcrumb-text">Resultados para "{{ $query }}"</span>
                                    </li>
                                @endisset
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- collection start -->
        <section class="main-content-wrap bg-color shop-page section-ptb">
            <div class="container">
                <div class="row">
                    <!-- Left Sidebar for Filters START -->
                    <div class="col-lg-3">
                        <div class="shop-filter-wrap">
                            <div class="collection-filter">
                                <h6 class="filter-title">Filtrar por</h6>

                                {{-- Filter by Categories --}}
                                <div class="filter-option filter-category">
                                    <h6 class="filter-sub-title">Categorías</h6>
                                    <ul class="filter-list">
                                        {{-- Example: Loop through categories to display them dynamically --}}
                                        {{-- @foreach ($categories as $category)
                                            <li><a href="#">{{ $category->name }}</a></li>
                                        @endforeach --}}
                                        <li><a href="#">Electrónica (12)</a></li>
                                        <li><a href="#">Gaming (8)</a></li>
                                        <li><a href="#">Audio (5)</a></li>
                                    </ul>
                                </div>

                                {{-- Filter by Price --}}
                                <div class="filter-option filter-price">
                                    <h6 class="filter-sub-title">Precio</h6>
                                    <div class="price-range">
                                        <input type="range" min="0" max="1000" value="0" class="slider" id="price-min">
                                        <input type="range" min="0" max="1000" value="1000" class="slider" id="price-max">
                                        <p>Rango: $<span id="price-display-min">0</span> - $<span id="price-display-max">1000</span></p>
                                        <button class="btn btn-primary btn-sm mt-2">Aplicar</button>
                                    </div>
                                </div>

                                {{-- Add more filter options here (e.g., Brands, Condition, etc.) --}}

                            </div>
                        </div>
                    </div>
                    <!-- Left Sidebar for Filters END -->

                    <div class="col-lg-9"> {{-- Changed from col to col-lg-9 to make space for sidebar --}}
                        <div class="pro-grli-wrapper"> {{-- Removed left-side-wrap as it's not needed with dedicated sidebar --}}
                            <div class="pro-grli-wrap product-grid">
                                <div class="collection-img-wrap">
                                    @isset($query)
                                        <h6 data-animate="animate__fadeInUp" class="st-title">Resultados de búsqueda para "{{ $query }}" ({{ $products->count() }})</h6>
                                    @else
                                        <h6 data-animate="animate__fadeInUp" class="st-title">Colección ({{ $products->count() }})</h6>
                                    @endisset
                                    <!-- collection info start -->
                                    {{-- Conditionally hide the banner if it's a search results page --}}
                                    @if (!isset($query))
                                        <div class="collection-info">
                                            <div class="collection-image" data-animate="animate__fadeInUp">
                                                <img src="{{ asset('img/banner/sall-banner.jpg') }}" class="img-fluid" alt="sall-banner">
                                            </div>
                                        </div>
                                    @endif
                                    <!-- collection info end -->
                                </div>
                                <!-- shop-top-bar start -->
                                <div class="shop-top-bar wow">
                                    {{-- Removed the filter-button as filters are now persistent in the sidebar --}}
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
                                        <ul class="pro-ul collapse">
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
                                            <div class="col-12"> {{-- Changed to col-12 to fit within the col-lg-9 parent --}}
                                                <div class="collection-wrap">
                                                    <ul class="product-view-ul">
                                                        @forelse ($products as $product)
                                                            <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                                <div class="single-product-wrap">
                                                                    <div class="product-image banner-hover">
                                                                        <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="pro-img">
                                                                            <img src="{{ Storage::url($product->main_image_path) }}" class="img-fluid img1 mobile-img1" alt="{{ $product->name }}">
                                                                            @if ($product->gallery_image_paths && count($product->gallery_image_paths) > 0)
                                                                                <img src="{{ Storage::url($product->gallery_image_paths[0]) }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
                                                                            @endif
                                                                        </a>
                                                                        <div class="product-action">
                                                                            <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                                <span class="tooltip-text">Vista rápida</span>
                                                                                <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                            </a>
                                                                            <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                                <span class="tooltip-text">Añadir al carrito</span>
                                                                                <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                            </a>
                                                                            <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                                <span class="tooltip-text">Lista de deseos</span>
                                                                                <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-caption">
                                                                        <div class="product-content">
                                                                            {{-- Suponiendo que tienes una relación de categoría o alguna forma de obtener la 'sub-title' --}}
                                                                            {{-- <div class="product-sub-title">
                                                                                <span>Wireless device</span>
                                                                            </div> --}}
                                                                            <div class="product-title">
                                                                                <h6><a href="{{ route('product.show', ['slug' => $product->slug]) }}">{{ $product->name }}</a></h6>
                                                                            </div>
                                                                            <div class="product-price">
                                                                                <div class="pro-price-box">
                                                                                    <span class="new-price">${{ number_format($product->price, 2) }}</span>
                                                                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                                                                        <span class="old-price">${{ number_format($product->sale_price, 2) }}</span>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <div class="product-description">
                                                                                <p>{{ $product->short_description }}</p>
                                                                            </div>
                                                                            <div class="product-action">
                                                                                <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                                    <span class="tooltip-text">Vista rápida</span>
                                                                                    <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                                                </a>
                                                                                <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                                    <span class="tooltip-text">Añadir al carrito</span>
                                                                                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                                                </a>
                                                                                <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                                    <span class="tooltip-text">Lista de deseos</span>
                                                                                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="pro-label-retting">
                                                                            {{-- Rating will be dynamically shown here if available --}}
                                                                            {{-- <div class="product-ratting">
                                                                                <span class="pro-ratting">
                                                                                    <i class="fa-solid fa-star"></i>
                                                                                    <i class="fa-solid fa-star"></i>
                                                                                    <i class="fa-solid fa-star"></i>
                                                                                    <i class="fa-solid fa-star"></i>
                                                                                    <i class="fa-solid fa-star"></i>
                                                                                </span>
                                                                            </div> --}}
                                                                            @if ($product->sale_price && $product->sale_price < $product->price)
                                                                                @php
                                                                                    $discountPercentage = (($product->price - $product->sale_price) / $product->price) * 100;
                                                                                @endphp
                                                                                <div class="product-label pro-new-sale">
                                                                                    <span class="product-label-title">Oferta<span>{{ round($discountPercentage) }}%</span></span>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @empty
                                                            <li class="col-span-full text-center py-10">
                                                                <p class="text-lg text-gray-500">No se encontraron productos para tu búsqueda.</p>
                                                            </li>
                                                        @endforelse
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
                </div>
            </section>
            <!-- collection end -->
    </main>
</x-app-layout>