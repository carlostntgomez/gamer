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
                                    <span class="breadcrumb-text">Tienda</span>
                                </li>
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
                                <h2 data-animate="animate__fadeInUp"><span>Nuestra Colección</span></h2>
                            </div>
                        </div>
                        
                        <!-- product-area start: Modificado para coincidir con la plantilla collection.html -->
                        <div class="product-area">
                            @if($products->count() > 0)
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">
                                    <p>No hay productos en nuestra colección en este momento.</p>
                                </div>
                            @endif
                            <div class="paginatoin-area">
                                {{ $products->links('vendor.pagination.bootstrap-5') }}
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
