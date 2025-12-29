@props(['product'])

@php
    $discountPercentage = $product->sale_price && $product->price > 0 ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
@endphp

<div class="single-product-wrap">
    <div class="product-image">
        <a href="{{ route('shop.show', $product) }}" class="pro-img">
            <img src="{{ $product->main_image_path ? Storage::url($product->main_image_path) : url('/images/placeholder-product.png') }}" class="img-fluid img1 mobile-img1" alt="{{ $product->name }}">
            @if(isset($product->gallery_image_paths[0]))
                <img src="{{ Storage::url($product->gallery_image_paths[0]) }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
            @else
                 <img src="{{ $product->main_image_path ? Storage::url($product->main_image_path) : url('/images/placeholder-product.png') }}" class="img-fluid img2 mobile-img2" alt="{{ $product->name }}">
            @endif
        </a>
        <div class="product-action">
            <a href="javascript:void(0)" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview" wire:click="$dispatch('show-product-quick-view', { product: {{ $product->id }} })">
                <span class="tooltip-text">Vista Rápida</span>
                <span class="pro-action-icon"><i class="feather-eye"></i></span>
            </a>
            <a href="javascript:void(0)" class="add-to-cart" wire:click="$dispatch('add-to-cart', { productId: {{ $product->id }}, quantity: 1 })">
                <span class="tooltip-text">Añadir al carrito</span>
                <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
            </a>
            <a href="javascript:void(0)" class="wishlist" wire:click="$dispatch('add-to-wishlist', { productId: {{ $product->id }} })">
                <span class="tooltip-text">Wishlist</span>
                <span class="pro-action-icon"><i class="feather-heart"></i></span>
            </a>
        </div>
    </div>
    <div class="product-content">
        @if($product->brand)
        <div class="product-sub-title">
            <span><a href="{{ route('brands.show', $product->brand) }}">{{ $product->brand->name }}</a></span>
        </div>
        @endif
        <div class="product-title">
            <h6><a href="{{ route('shop.show', $product) }}">{{ $product->name }}</a></h6>
        </div>
        <div class="product-price">
            <div class="pro-price-box">
                <span class="new-price">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                @if($product->sale_price)
                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
    <div class="pro-label-retting">
        <div class="product-ratting">
            {!! $product->getStarRatingHtml() !!}
        </div>
         @if($product->sale_price)
        <div class="product-label pro-new-sale">
            <span class="product-label-title">
                Sale<span>{{ $discountPercentage }}%</span>
            </span>
        </div>
        @endif
    </div>
</div>
