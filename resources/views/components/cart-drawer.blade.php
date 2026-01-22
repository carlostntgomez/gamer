@php
    // Estos valores se inicializan solo si no se pasan desde el controlador
    $cart = $cart ?? session()->get('cart', []);
    $cartCount = $cartCount ?? array_sum(array_column($cart, 'quantity'));
    $subtotal = $subtotal ?? array_reduce($cart, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);
@endphp

<div class="cart-drawer" id="cart-drawer">
    {{-- El contenido se carga dinámicamente vía AJAX por el script refreshCartDrawer() --}}
    {{-- Sin embargo, dejamos una estructura base por si JavaScript falla --}}
    <div class="drawer-fixed-header">
        <div class="drawer-header">
            <h6 class="drawer-header-title">Carrito</h6>
            <div class="drawer-close">
                <button type="button" class="drawer-close-btn">
                    <span class="drawer-close-icon">X</span>
                </button>
            </div>
        </div>
    </div>
    <div class="drawer-inner">
        @if(empty($cart))
            <div class="drawer-cart-empty text-center">
                <h2 class="mt-5">Tu carrito está vacío</h2>
                <a href="{{ route('shop.index') }}" class="btn btn-style2 mt-3">Continuar comprando</a>
            </div>
        @else
            <div class="drawer-scrollable">
                <ul class="cart-items">
                    @foreach($cart as $rowId => $details)
                        @php
                            $product = \App\Models\Product::find($details['product_id']);
                            $productUrl = $product ? route('shop.show', $product->slug) : '#';
                            $imageUrl = $details['image'] ?? url('/images/placeholder-product.png');
                        @endphp
                        <li class="cart-item" data-id="{{ $rowId }}">
                            <div class="cart-item-info">
                                <div class="cart-item-image">
                                    <a href="{{ $productUrl }}">
                                        <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $details['name'] }}">
                                    </a>
                                </div>
                                <div class="cart-item-details">
                                    <div class="cart-item-sub">
                                        <div class="cart-item-name">
                                            <a href="{{ $productUrl }}">{{ $details['name'] }}</a>
                                        </div>
                                        <div class="cart-item-price">
                                            <span class="cart-price">${{ number_format($details['price'], 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="cart-qty-price-remove">
                                        {{-- El wrapper debe tener la clase correcta para que lo encuentre el script --}}
                                        <div class="js-qty-wrap">
                                            <button type="button" class="js-qty-adjust" data-id="{{ $rowId }}" data-action="decrease">-</button>
                                            <input type="text" class="js-qty-num" value="{{ $details['quantity'] }}" readonly>
                                            <button type="button" class="js-qty-adjust" data-id="{{ $rowId }}" data-action="increase">+</button>
                                        </div>
                                        <div class="cart-item-remove">
                                            <button type="button" class="cart-remove" data-id="{{ $rowId }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="drawer-notes">
                    <label for="cartnote">Nota del pedido</label>
                    <textarea name="note" class="cart-notes" id="cartnote"></textarea>
                </div>
            </div>
            <div class="drawer-footer">
                <div class="drawer-total">
                    <span class="drawer-subtotal">Subtotal</span>
                    <span class="drawer-totalprice">${{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="drawer-ship-text">
                    <span>Los impuestos y el envío se calculan en el checkout.</span>
                </div>
                <div class="drawer-cart-checkout">
                    <div class="cart-checkout-btn">
                        {{-- Corregimos el enlace para que apunte a la ruta correcta --}}
                        <button type="button" onclick="location.href='{{ route('cart.index') }}'" class="btn btn-style2">Ver carrito</button>
                        <button type="button" onclick="location.href='{{ route('checkout.index') }}'" class="checkout btn btn-style2">Pagar</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
