@props(['newProducts'])

@if ($newProducts->isNotEmpty())
    <section class="special-product section-pt">
        <div class="collection-category">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <div class="section-cont-title">
                                    <h2 data-animate="animate__fadeInUp"><span>Nuevos Productos</span></h2>
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
                            {{-- IDs modificados para el nuevo carrusel --}}
                            <div class="collection-slider swiper" id="new-product-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($newProducts as $product)
                                        <div class="swiper-slide" data-animate="animate__fadeInUp">
                                            <x-product-card :product="$product" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="swiper-buttons">
                                <div class="swiper-buttons-wrap">
                                    <button class="swiper-prev swiper-prev-new"><span><i class="fa-solid fa-arrow-left"></i></span></button>
                                    <button class="swiper-next swiper-next-new"><span><i class="fa-solid fa-arrow-right"></i></span></button>
                                </div>
                            </div>
                            <div class="swiper-dots">
                                <div class="swiper-pagination swiper-pagination-new"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

{{-- Script para inicializar el carrusel de Nuevos Productos --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('#new-product-slider', {
            loop: false,
            slidesPerView: 4,
            spaceBetween: 30,
            observer: true,
            observeParents: true,
            watchSlidesProgress: true,
            navigation: {
                prevEl: '.swiper-prev-new',
                nextEl: '.swiper-next-new',
            },
            pagination: {
                el: '.swiper-pagination-new',
                clickable: true,
            },
            autoplay: false,
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 12,
                },
                360: {
                    slidesPerView: 2,
                    spaceBetween: 12,
                },
                640: {
                    slidesPerView: 3,
                    spaceBetween: 12,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
            },
        });
    });
</script>
@endpush
