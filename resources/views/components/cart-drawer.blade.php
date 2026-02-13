@php
    $cart = $cart ?? session()->get('cart', []);
    $cartCount = $cartCount ?? array_sum(array_column($cart, 'quantity'));
    $subtotal = $subtotal ?? array_reduce($cart, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);
@endphp

<div class="cart-drawer" id="cart-drawer">
    <form class="drawer-contents">
        <div class="drawer-fixed-header">
            <div class="drawer-header">
                <h6 class="drawer-header-title">Carrito</h6>
                <div class="drawer-close">
                    <button type="button" class="drawer-close-btn"><span class="drawer-close-icon"><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span></button>
                </div>
            </div>
        </div>
        @if(empty($cart))
            <div class="drawer-cart-empty text-center">
                <div class="drawer-scrollable">
                    <div class="cart-empty-icon mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="81" height="81" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    </div>
                    <h2>Tu carrito está actualmente vacío</h2>
                    <p class="mb-4">Parece que aún no has añadido nada a tu carrito.</p>
                    <a href="{{ route('shop.index') }}" class="btn btn-style2">Continuar comprando</a>
                </div>
            </div>
        @else
            <div class="drawer-inner">
                <div class="drawer-scrollable">
                    <ul class="cart-items">
                        @foreach($cart as $rowId => $details)
                            @php
                                $productUrl = isset($details['slug']) ? route('shop.show', $details['slug']) : '#';
                            @endphp
                            <li class="cart-item" data-id="{{ $rowId }}">
                                <div class="cart-item-info">
                                    <div class="cart-item-image">
                                        <a href="{{ $productUrl }}">
                                            <img src="{{ isset($details['image']) && $details['image'] ? Storage::url($details['image']) : url('/images/placeholder-product.png') }}" class="img-fluid" alt="{{ $details['name'] }}">
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
                                            <div class="cart-item-qty">
                                                <div class="js-qty-wrapper">
                                                    <div class="js-qty-wrap">
                                                        <button type="button" class="js-qty-adjust ju-qty-adjust-minus" data-id="{{ $rowId }}" data-action="decrease"><span><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="5" y1="12" x2="19" y2="12"></line></svg></span></button>
                                                        <input type="text" class="js-qty-num" value="{{ $details['quantity'] }}" readonly>
                                                        <button type="button" class="js-qty-adjust ju-qty-adjust-plus" data-id="{{ $rowId }}" data-action="increase"><span><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-item-remove">
                                                <button type="button" class="cart-remove text-danger" data-id="{{ $rowId }}"><span><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="drawer-notes">
                        <label for="cartnote">Nota del pedido</label>
                        <textarea name="note" class="cart-notes" id="cartnote" placeholder="Instrucciones especiales..."></textarea>
                    </div>
                </div>
                <div class="drawer-footer">
                    <div class="drawer-total">
                        <span class="drawer-subtotal">Subtotal</span>
                        <span class="drawer-totalprice">${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="drawer-ship-text">
                        <span>Envío e impuestos calculados al finalizar la compra.</span>
                    </div>
                    <div class="drawer-cart-checkout">
                        <div class="cart-checkout-btn">
                            <a href="{{ route('checkout.index') }}" class="btn btn-style2">Finalizar Compra</a>
                            <a href="{{ route('cart.index') }}" class="btn btn-style">Ver Carrito</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
