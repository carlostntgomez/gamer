@props(['product'])

@php
    $discountPercentage = $product->sale_price && $product->price > 0 ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
@endphp

<div class="single-product-wrap">
    <div class="product-image banner-hover">
        <a href="{{ route('shop.show', $product) }}" class="pro-img">
            <img src="{{ $product->main_image_url }}" class="img-fluid img1 mobile-img1" alt="{{ $product->name }}">
            <img src="{{ $product->gallery_image_urls[0] ?? $product->main_image_url }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
        </a>

        @if($product->isOnSale())
            <div class="product-label pro-new-sale">
                <span class="product-label-title">Oferta</span>
            </div>
        @elseif($product->is_new)
             <div class="product-label pro-new-sale">
                <span class="product-label-title">Nuevo</span>
            </div>
        @endif

        <div class="product-action">
            <a href="javascript:void(0)" class="quick-view-btn"
               data-bs-toggle="modal"
               data-bs-target="#quickview"
               data-product-slug="{{ $product->slug }}">
                <span class="tooltip-text">Vista Rápida</span>
                <span class="pro-action-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
            </a>
        </div>
        <div class="product-add-cart">
            {{-- La clase `ajax-spin-cart` se eliminó para dar control a `cart.js` --}}
            {{-- Ahora usamos la función global `addToCart` desde un script en `app.blade.php` --}}
            <a href="javascript:void(0)" class="add-to-cart-btn" data-product-id="{{ $product->id }}">
                <span class="cart-title">+ Añadir al carrito</span>
            </a>
        </div>
    </div>
    <div class="product-content">
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
        {{-- SECCIÓN DE ACCIONES INFERIORES ELIMINADA PARA SIMPLIFICAR --}}
    </div>
</div>
