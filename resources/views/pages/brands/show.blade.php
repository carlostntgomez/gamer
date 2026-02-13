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
                                    <a class="breadcrumb-link" href="/">Inicio</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="#">Marcas</a>
                                </li>
                                 <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">{{ $brand->name }}</span>
                                </li>
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
                    <div class="col">
                        <div class="pro-grli-wrapper left-side-wrap">
                            <div class="pro-grli-wrap product-grid">
                                <div class="collection-img-wrap">
                                    <h6 data-animate="animate__fadeInUp" class="st-title">{{ $brand->name }} ({{ $products->total() }})</h6>
                                </div>
                                <!-- shop-top-bar start -->
                                <div class="shop-top-bar wow">
                                    <div class="product-filter without-sidebar">
                                        <button class="filter-button" type="button"><i class="fa-solid fa-filter"></i><span>Filtros</span></button>
                                    </div>
                                    <div class="product-view-mode">
                                        <!-- shop-item-filter-list start -->
                                        <a href="javascript:void(0)" class="list-change-view grid-three active" data-grid-view="3"><i class="fa-solid fa-border-all"></i></a>
                                        <a href="javascript:void(0)" data-grid-view="1" class="list-change-view list-one"><i class="fa-solid fa-list"></i></a>
                                        <!-- shop-item-filter-list end -->
                                    </div>
                                    <!-- product-short start -->
                                    <div class="product-short">
                                        <label for="SortBy">Ordenar por:</label>
                                        <select class="nice-select" name="sortby" id="SortBy">
                                            <option value="manual">Destacados</option>
                                            <option value="best-selling">Más vendidos</option>
                                            <option value="title-ascending">Alfabéticamente, A-Z</option>
                                            <option value="title-descending">Alfabéticamente, Z-A</option>
                                            <option value="price-ascending">Precio, menor a mayor</option>
                                            <option value="price-descending">Precio, mayor a menor</option>
                                            <option value="created-descending">Fecha, nuevo a antiguo</option>
                                            <option value="created-ascending">Fecha, antiguo a nuevo</option>
                                        </select>
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
                                                        @foreach($products as $product)
                                                            <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                                <x-product-card :product="$product" />
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                {{ $products->links('vendor.pagination.bootstrap-5') }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Latest-product end -->
                                </div>
                            </div>
                            <div class="pro-grli-wrap product-sidebar">
                                <div class="pro-grid-block">
                                    <div class="shop-sidebar-inner">
                                        <div class="shop-sidebar-wrap filter-sidebar">
                                            <!-- button start -->
                                            <button class="close-sidebar" type="button">
                                            <i class="fa-solid fa-xmark"></i>
                                            </button>
                                            <!-- button end -->
                                            <!-- filter-form start -->
                                            <div class="facets">
                                                <form class="facets-form">
                                                    <div class="facets-wrapper">
                                                        <!-- Product-Categories start -->
                                                        <div class="shop-sidebar">
                                                            <h6 class="shop-title" data-animate="animate__fadeInUp">Categorías</h6>
                                                            <a href="#collapse-5" data-bs-toggle="collapse" class="shop-title shop-title-lg" data-animate="animate__fadeInUp">Categorías<i class="fa fa-angle-down"></i></a>
                                                            <div class="collapse show shop-element" id="collapse-5">
                                                                <ul class="brand-ul scrollbar">
                                                                    @foreach($allCategories as $cat)
                                                                    <li class="cat-checkbox" data-animate="animate__fadeInUp">
                                                                        <label class="checkbox-label">
                                                                            <input type="checkbox" class="cust-checkbox" name="categories[]" value="{{ $cat->id }}" onchange="this.form.submit()">
                                                                            <span class="check-name">{{ $cat->name }}</span>
                                                                            <span class="count-check">({{ $cat->products_count }})</span>
                                                                            <span class="cust-check"></span>
                                                                        </label>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- Product-Categories end -->
                                                        <!-- Product-brand start -->
                                                        <div class="shop-sidebar">
                                                            <h6 class="shop-title" data-animate="animate__fadeInUp">Marcas</h6>
                                                            <a href="#collapse-6" data-bs-toggle="collapse" class="shop-title shop-title-lg" data-animate="animate__fadeInUp">Marcas<i class="fa fa-angle-down"></i></a>
                                                            <div class="collapse show shop-element" id="collapse-6">
                                                                <ul class="brand-ul scrollbar">
                                                                    @foreach($allBrands as $b)
                                                                    <li class="cat-checkbox" data-animate="animate__fadeInUp">
                                                                        <label class="checkbox-label">
                                                                            <input type="checkbox" class="cust-checkbox" onchange="window.location.href='{{ route('brands.show', $b) }}'" {{ $b->id === $brand->id ? 'checked' : '' }}>
                                                                            <span class="check-name">{{ $b->name }}</span>
                                                                            <span class="count-check">({{ $b->products_count }})</span>
                                                                            <span class="cust-check"></span>
                                                                        </label>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- Product-brand end -->
                                                        <!-- Product-price start -->
                                                        <div class="shop-sidebar">
                                                            <h6 class="shop-title" data-animate="animate__fadeInUp">Precio</h6>
                                                            <a href="#collapse-7" data-bs-toggle="collapse" class="shop-title shop-title-lg" data-animate="animate__fadeInUp">Precio<i class="fa fa-angle-down"></i></a>
                                                            <div class="collapse show shop-element" id="collapse-7">
                                                                <div class="price-range-slider">
                                                                    <div id="slider-range"></div>
                                                                    <p>
                                                                        <label for="amount">Rango:</label>
                                                                        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                                                        <input type="hidden" name="min_price" id="min_price">
                                                                        <input type="hidden" name="max_price" id="max_price">
                                                                    </p>
                                                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Product-price end -->
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
            </div>
        </section>
        <!-- collection end -->
    </main>
    <!-- main section end-->
    @push('scripts')
    <script>
        $( function() {
            $( "#slider-range" ).slider({
                range: true,
                min: {{ $minPrice ?? 0 }},
                max: {{ $maxPrice ?? 5000 }},
                values: [ {{ request()->get('min_price', $minPrice) ?? 0 }}, {{ request()->get('max_price', $maxPrice) ?? 5000 }} ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
                    $( "#min_price" ).val(ui.values[ 0 ]);
                    $( "#max_price" ).val(ui.values[ 1 ]);
                }
            });
            $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
                " - $" + $( "#slider-range" ).slider( "values", 1 ) );
        } );
    </script>
    @endpush
</x-app-layout>
