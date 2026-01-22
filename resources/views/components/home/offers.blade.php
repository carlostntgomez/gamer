@if($offers->isNotEmpty())
<section class="banner-offer section-pt">
    <div class="banner-content">
        <ul class="offer-ul">
            @foreach($offers as $offer)
            <li class="offer-li">
                <div class="offer-wrap">
                    <a href="{{ $offer->cta_link }}" class="banner-img">
                        <img src="{{ Illuminate\Support\Facades\Storage::url($offer->image_path) }}" class="img-fluid" alt="{{ $offer->title }}">
                    </a>
                    <div class="offer-text-content">
                        <div class="offer-text-info">
                            @if($offer->subtitle)
                            <span class="offer-subtitle" data-animate="animate__fadeInUp">{{ $offer->subtitle }}</span>
                            @endif
                            <h2 data-animate="animate__fadeInUp">{{ $offer->title }}</h2>
                            <a href="{{ $offer->cta_link }}" class="btn btn-style3" data-animate="animate__fadeInUp">{{ $offer->cta_text }}</a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</section>
@endif
