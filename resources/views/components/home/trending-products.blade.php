@if ($featuredProducts->isNotEmpty())
    <section class="special-product section-pt">
    <div class="collection-category">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <div class="section-cont-title">
                                <h2 data-animate="animate__fadeInUp"><span>Productos Destacados</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="collection-wrap">
                        <div class="collection-slider swiper" id="special-product8">
                            <div class="swiper-wrapper">
                                @foreach ($featuredProducts as $product)
                                    <div class="swiper-slide" data-animate="animate__fadeInUp">
                                        <div class="single-product-wrap">
                                            <div class="product-image banner-hover">
                                                <a href="{{ route('shop.show', $product) }}" class="pro-img">
                                                    <img src="{{ Storage::url($product->main_image_path) }}" class="img-fluid img1 mobile-img1" alt="{{ $product->name }}">
                                                    @if(isset($product->gallery_image_paths[0]))
                                                        <img src="{{ Storage::url($product->gallery_image_paths[0]) }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }} hover">
                                                    @endif
                                                </a>
                                                <div class="product-label pro-new-sale">
                                                    @if ($product->is_new)
                                                        <span class="product-label-title">Nuevo</span>
                                                    @elseif ($product->sale_price)
                                                        <span class="product-label-title">Oferta</span>
                                                    @endif
                                                </div>
                                                <div class="product-action">
                                                    <a href="#" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview" title="Vista Rápida">
                                                        <span class="tooltip-text">Vista Rápida</span>
                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                                                    </a>
                                                    <a href="#" class="wishlist" title="Añadir a la lista de deseos">
                                                        <span class="tooltip-text">Lista de Deseos</span>
                                                        <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span>
                                                    </a>
                                                </div>
                                                <div class="product-add-cart">
                                                    <a href="javascript:void(0)" class="add-to-cart ajax-spin-cart">
                                                        <span class="cart-title">+Añadir al carrito</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <div class="product-title">
                                                    <h6><a href="{{ route('shop.show', $product) }}">{{ $product->name }}</a></h6>
                                                </div>
                                                <div class="product-price">
                                                    <div class="pro-price-box">
                                                        <span class="new-price">{{ format_price($product->sale_price ?? $product->price) }}</span>
                                                        @if ($product->sale_price)
                                                            <span class="old-price">{{ format_price($product->price) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-buttons">
                            <div class="swiper-buttons-wrap">
                                <button class="swiper-prev swiper-prev-special8"><span><i class="fa-solid fa-arrow-left"></i></span></button>
                                <button class="swiper-next swiper-next-special8"><span><i class="fa-solid fa-arrow-right"></i></span></button>
                            </div>
                        </div>
                        <div class="swiper-dots">
                            <div class="swiper-pagination swiper-pagination-special8"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif