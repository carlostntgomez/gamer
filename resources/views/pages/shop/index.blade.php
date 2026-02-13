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
                                    <a class="breadcrumb-link" href="{{ route('shop.index') }}">Tienda</a>
                                </li>
                                @isset($searchTerm)
                                    <li class="breadcrumb-li">
                                        <span class="breadcrumb-text">Búsqueda</span>
                                    </li>
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->

        <!-- collection section start -->
        <section class="collection-page bg-color section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                @isset($searchTerm)
                                    <h2 data-animate="animate__fadeInUp">Resultados para: <span>{{ $searchTerm }}</span></h2>
                                @else
                                    <h2 data-animate="animate__fadeInUp"><span>Nuestra Colección</span></h2>
                                @endisset
                            </div>
                        </div>
                        
                        <!-- product-area start -->
                        <div class="product-area">
                            @if($products->count() > 0)
                                <div class="row gy-4">
                                    @foreach($products as $product)
                                        <div class="col-lg-4 col-md-6 col-12" data-animate="animate__fadeInUp">
                                            <x-product-card :product="$product" />
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center">
                                    @isset($searchTerm)
                                        <p>No se encontraron productos para tu búsqueda '{{ $searchTerm }}'.</p>
                                    @else
                                        <p>No hay productos en nuestra colección en este momento.</p>
                                    @endisset
                                </div>
                            @endif
                            <div class="paginatoin-area">
                                {{-- Aseguramos que la paginación persista en la búsqueda --}}
                                {{ $products->appends(request()->input())->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                        <!-- product-area end -->

                    </div>
                </div>
            </div>
        </section>
        <!-- collection section end -->
    </main>
    <!-- main section end-->
</x-layouts.app>
