@props(['product'])

<div {{ $attributes->merge(['class' => 'single-product-wrap']) }}>
    <div class="product-image banner-hover">
        <a href="{{ route('shop.show', $product) }}" class="pro-img">
            <img src="{{ $product->main_image_url }}" class="img-fluid img1 mobile-img1" alt="{{ $product->name }}">
            <img src="{{ $product->gallery_image_urls[0] ?? $product->main_image_url }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
        </a>

        {{-- Sección para wishlist y quickview que se ignora --}}
        <div class="product-action">
        </div>

        {{-- Botón de hover: con las clases 'ajax-spin-cart' para el estilo y 'add-to-cart-btn' para el JS --}}
        <div class="product-add-cart">
            <a href="javascript:void(0)" class="add-to-cart ajax-spin-cart add-to-cart-btn" data-product-id="{{ $product->id }}">
                <span class="cart-title">+ Añadir al carrito</span>
            </a>
        </div>
    </div>
    <div class="product-content">
         @if($product->category)
            <div class="product-sub-title">
                <span>{{ $product->category->name }}</span>
            </div>
        @endif
        <div class="product-title">
            <h6><a href="{{ route('shop.show', $product) }}">{{ $product->name }}</a></h6>
        </div>
        <div class="product-price">
            <div class="pro-price-box">
                <span class="new-price">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                @if($product->isOnSale())
                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
        </div>
        <div class="product-description">
            <p>{{ $product->short_description }}</p>
        </div>
        <div class="product-ratting">
            {!! $product->getStarRatingHtml() !!}
        </div>

        {{-- Botón inferior: con la clase 'add-to-cart' para el estilo y 'add-to-cart-btn' para el JS --}}
        <div class="product-action">
             <a href="javascript:void(0)" class="add-to-cart add-to-cart-btn" data-product-id="{{ $product->id }}">
                <span class="tooltip-text">Añadir al carrito</span>
                <span class="pro-action-icon"><i class="fa-solid fa-cart-shopping"></i></span>
            </a>
        </div>
    </div>
</div>
