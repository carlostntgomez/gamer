<section class="banner-grid section-pt">
    <div class="banner-content">
        <ul class="banner-ul">
            @foreach ($banners as $banner)
                <li class="banner-li">
                    <div class="banner-wrap banner-hover">
                        <a href="{{ $banner->url }}">
                            <img src="{{ Illuminate\Support\Facades\Storage::url($banner->image_path) }}" class="img-fluid" alt="{{ $banner->name }}">
                        </a>
                        <div class="banner-wrapper">
                            <div class="banner-info">
                                <h2 data-animate="animate__fadeInUp">{{ $banner->name }}</h2>
                                <div class="banner-link" data-animate="animate__fadeInUp">
                                    <a href="{{ $banner->url }}" class="btn btn-style3">Comprar ahora</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</section>
