<x-layouts.app>
    <!-- main section start-->
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="breadcrumb-index">
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">Búsqueda</span>
                                </li>
                            </ul>
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
                                <h2 data-animate="animate__fadeInUp"><span>Tu búsqueda de "{{ $query }}" arrojó {{ $products->total() }} resultados:</span></h2>
                            </div>
                        </div>
                        <div class="saerch-input" data-animate="animate__fadeInUp">
                            <form action="{{ route('shop.search') }}" method="GET">
                                <input type="text" name="query" placeholder="Busca en nuestra tienda" value="{{ $query }}">
                                <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        
                        <!-- special-product start -->
                        <div class="special-product grid-3">
                            <div class="collection-category">
                                <div class="row">
                                    <div class="col">
                                        <div class="collection-wrap">
                                            @if($products->count() > 0)
                                                <ul class="product-view-ul">
                                                    @foreach($products as $product)
                                                        <li class="pro-item-li" data-animate="animate__fadeInUp">
                                                            <x-product-card :product="$product" />
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="text-center py-5">
                                                    <p>No se encontraron productos que coincidan con tu búsqueda.</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="paginatoin-area">
                                            {{ $products->appends(['query' => $query])->links('vendor.pagination.bootstrap-5') }}
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
</x-layouts.app>
