<div class="brand-logo section-ptb">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="brand-logo-wrap">
                    @if($brands->isNotEmpty())
                        <div class="brand-logo-slider owl-carousel owl-theme" id="brand-logo8">
                            @foreach($brands as $brand)
                                <div class="item" data-animate="animate__fadeInUp">
                                    <a href="{{ $brand->slug ? route('brands.show', ['brand' => $brand->slug]) : '#' }}">
                                        <span class="brand-img">
                                            <img src="{{ Storage::url($brand->logo_path) }}" class="img-fluid" alt="{{ $brand->name ?? 'Brand Logo' }}">
                                        </span>
                                    </a>
                                </div>
                            @endforeach
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
</div>