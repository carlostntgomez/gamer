<x-layouts.app>
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
                                    <a class="breadcrumb-link" href="/">Inicio</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">Tienda</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
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
                        <!-- special-product start -->
                        <div class="special-product grid-3">
                            <div class="collection-category">
                                <div class="row">
                                    <div class="col">
                                        <div class="collection-wrap">
                                            @if($products->count() > 0)
                                            <ul class="product-view-ul">
                                                @foreach($products as $product)
                                                    <x-product-card :product="$product" />
                                                @endforeach
                                            </ul>
                                            @else
                                            <div class="text-center">
                                                <p>No hay productos en nuestra colección en este momento.</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="paginatoin-area">
                                             {{ $products->links('vendor.pagination.bootstrap-5') }}
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
        <!-- collection section end -->
    </main>
    <!-- main section end-->
</x-layouts.app>
