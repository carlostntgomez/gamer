@props(['product'])

<div class="modal-header">
    <h6 class="modal-quickview">Vista Rápida</h6>
    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
</div>

{{-- El contenedor .row es CRÍTICO para que el contenido se renderice correctamente --}}
<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="quickview-slider">
            <!-- Main Gallery -->
            <div class="swiper gallery-top">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ $product->main_image_url }}" class="img-fluid" alt="{{ $product->name }}">
                    </div>
                    @foreach($product->gallery_image_urls as $imageUrl)
                        <div class="swiper-slide">
                            <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $product->name }}">
                        </div>
                    @endforeach
                </div>
                <!-- Navigation -->
                <div class="swiper-button">
                    <button class="quick-prev"><i class="fas fa-chevron-left"></i></button>
                    <button class="quick-next"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <!-- Thumbnails -->
            @if (count($product->gallery_image_urls) > 0)
                <div class="swiper gallery-thumbs">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ $product->main_image_url }}" class="img-fluid" alt="{{ $product->name }}">
                        </div>
                        @foreach($product->gallery_image_urls as $imageUrl)
                            <div class="swiper-slide">
                                <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-6 col-md-6">
        <div class="quick-view-content">
            <div class="pro-nprist">
                <div class="product-title">
                    <span>{{ $product->brand->name ?? 'TecnnyGames' }}</span>
                    <h6>{{ $product->name }}</h6>
                </div>

                <div class="product-price">
                    <div class="pro-price-box">
                        <span class="new-price">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                        @if($product->isOnSale())
                            <span class="old-price">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>
                </div>

                <div class="product-ratting">
                    {!! $product->getStarRatingHtml() !!}
                </div>

                <div class="product-desc">
                    <p>{{ $product->short_description }}</p>
                </div>

                <div class="quickview-buttons mt-4">
                    <a href="{{ route('shop.show', $product) }}" class="btn btn-style">Ver más detalles</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT para la galería de imágenes, no se necesita lógica de carrito aquí -->
<script>
(function() {
    setTimeout(function() {
        if (window.quickViewGalleryTopInstance) window.quickViewGalleryTopInstance.destroy(true, true);
        if (window.quickViewGalleryThumbsInstance) window.quickViewGalleryThumbsInstance.destroy(true, true);

        window.quickViewGalleryThumbsInstance = new Swiper('.quickview-slider .gallery-thumbs', {
            spaceBetween: 10, 
            slidesPerView: 4, 
            freeMode: true, 
            watchSlidesProgress: true,
        });

        window.quickViewGalleryTopInstance = new Swiper('.quickview-slider .gallery-top', {
            spaceBetween: 10,
            navigation: { 
                nextEl: '.quickview-slider .quick-next', 
                prevEl: '.quickview-slider .quick-prev' 
            },
            thumbs: {
                swiper: window.quickViewGalleryThumbsInstance
            },
        });
    }, 150);
})();
</script>
