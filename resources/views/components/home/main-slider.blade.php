@php
$sliders = \App\Models\MainSlider::all();
@endphp

<section class="slider-content">
    <div class="home-slider swiper" id="home8-slider">
        <div class="swiper-wrapper">
            @foreach ($sliders as $slider)
            @php
                // Lógica para determinar la ruta de la imagen de escritorio
                $imagePath = $slider->image_path;
                if (!str_starts_with($imagePath, 'http')) {
                    if (str_starts_with($imagePath, 'img')) {
                        $imagePath = asset($imagePath);
                    } else {
                        $imagePath = asset('storage/' . $imagePath);
                    }
                }

                // Lógica para determinar la ruta de la imagen móvil
                $imagePathMobile = $slider->image_path_mobile;
                if ($imagePathMobile && !str_starts_with($imagePathMobile, 'http')) {
                     if (str_starts_with($imagePathMobile, 'img')) {
                        $imagePathMobile = asset($imagePathMobile);
                    } else {
                        $imagePathMobile = asset('storage/' . $imagePathMobile);
                    }
                } else if (!$imagePathMobile) {
                    // Fallback a la imagen de escritorio si no hay imagen móvil
                    $imagePathMobile = $imagePath;
                }

                // Lógica para separar título y precio
                $titleText = $slider->title;
                $titlePrice = '';
                if (str_contains($slider->title, '$')) {
                    $titleParts = explode('$', $slider->title);
                    $titleText = trim($titleParts[0]);
                    $titlePrice = isset($titleParts[1]) ? '$' . trim($titleParts[1]) : '';
                }
            @endphp
            <div class="swiper-slide">
                <div class="slider-image-info">
                    <div class="slider-image">
                        <img src="{{ $imagePath }}" class="img-fluid desk-img" alt="slider-desktop">
                        <img src="{{ $imagePathMobile }}" class="img-fluid mobile-img" alt="slider-mobile">
                    </div>
                    <div class="slider-text-content container">
                        <div class="slider-text-info slider-content-right slider-text-left">
                            <div class="slider-subtitle">
                                <span>{{ $titleText }}</span>
                                @if($titlePrice)
                                    <span class="sub-price">{{ $titlePrice }}</span>
                                @endif
                            </div>
                            {!! $slider->subtitle !!}
                            <div class="slider-link">
                                <a href="{{ $slider->button_link }}" class="btn btn-style">{{ $slider->button_text }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="container">
            <div class="swiper-buttons">
                <div class="swiper-buttons-wrap">
                    <button class="swiper-prev swiper-prev-homeslider8"><span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg></span></button>
                    <button class="swiper-next swiper-next-homeslider8"><span><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg></span></button>
                </div>
            </div>
            <div class="swiper-dots">
                <div class="swiper-pagination swiper-pagination-homeslider8"></div>
            </div>
        </div>
    </div>
</section>