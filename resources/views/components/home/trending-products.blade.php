@props(['featuredProducts'])

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
                                            <x-product-card :product="$product" />
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
