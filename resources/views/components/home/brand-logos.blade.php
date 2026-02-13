@props(['brands'])

<div class="brand-logo section-ptb">
    <div class="container">
        <div class="row">
            <div class="col">
                @if($brands->isNotEmpty())
                    <!-- Usando Swiper.js como en top-categories -->
                    <div class="swiper" id="brand-logo-swiper">
                        <div class="swiper-wrapper">
                            @foreach($brands as $brand)
                                <div class="swiper-slide">
                                    <a href="{{ $brand->slug ? route('brands.show', ['brand' => $brand->slug]) : '#' }}" class="d-block text-center">
                                        <img src="{{ $brand->logo_url }}" class="img-fluid" alt="{{ $brand->name ?? 'Brand Logo' }}" style="max-height: 80px; width: auto; margin: auto;">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <!-- Si quieres paginación o flechas, se pueden añadir aquí -->
                    </div>
                @else
                    <div class="text-center">
                        <p>No hay logos de marcas para mostrar.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicialización de Swiper para el carrusel de marcas
        var brandSwiper = new Swiper('#brand-logo-swiper', {
            loop: true,
            slidesPerView: 2,
            spaceBetween: 15,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            breakpoints: {
                540: {
                    slidesPerView: 3,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 30
                },
                1024: {
                    slidesPerView: 5,
                    spaceBetween: 30
                },
                1200: {
                    slidesPerView: 6,
                    spaceBetween: 30
                }
            }
        });
    });
</script>
@endpush
