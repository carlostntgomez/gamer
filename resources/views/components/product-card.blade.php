<?php
if (!function_exists('format_price')) {
    function format_price($price)
    {
        return '$ ' . number_format($price, 2);
    }
}
?>
@props(['product'])

<li class="pro-item-li" data-animate="animate__fadeInUp">
    <div class="single-product-wrap">
        <div class="product-image banner-hover">
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
                <a href="javascript:void(0)" class="add-to-cart" wire:click="$dispatch('add-to-cart', { product: {{ $product->id }} })">
                    <span class="tooltip-text">Añadir al carrito</span>
                    <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                </a>
                <a href="javascript:void(0)" class="wishlist" wire:click="$dispatch('add-to-wishlist', { product: {{ $product->id }} })">
                    <span class="tooltip-text">Lista de deseos</span>
                    <span class="pro-action-icon"><i class="feather-heart"></i></span>
                </a>
            </div>
        </div>
        <div class="product-caption">
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
                        <span class="new-price">{{ format_price($product->sale_price) }}</span>
                        @if($product->price > $product->sale_price)
                        <span class="old-price">{{ format_price($product->price) }}</span>
                        @endif
                    </div>
                </div>
                <div class="product-description">
                    <p>{{ $product->short_description }}</p>
                </div>
                <div class="product-action">
                    <a href="javascript:void(0)" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview" wire:click="$dispatch('show-product-quick-view', { product: {{ $product->id }} })">
                        <span class="tooltip-text">Vista Rápida</span>
                        <span class="pro-action-icon"><i class="feather-eye"></i></span>
                    </a>
                    <a href="javascript:void(0)" class="add-to-cart" wire:click="$dispatch('add-to-cart', { product: {{ $product->id }} })">
                        <span class="tooltip-text">Añadir al carrito</span>
                        <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                    </a>
                    <a href="javascript:void(0)" class="wishlist" wire:click="$dispatch('add-to-wishlist', { product: {{ $product->id }} })">
                        <span class="tooltip-text">Lista de deseos</span>
                        <span class="pro-action-icon"><i class="feather-heart"></i></span>
                    </a>
                </div>
            </div>
            <div class="pro-label-retting">
                <div class="product-ratting">
                    <span class="pro-ratting">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </span>
                </div>
                 @if($product->price > $product->sale_price)
                <div class="product-label pro-new-sale">
                    <span class="product-label-title">OFERTA</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</li>