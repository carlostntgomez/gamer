<!-- cart-drawer start -->
<div class="cart-drawer" id="cart-drawer">
    <form action="/cart" method="post" class="drawer-contents">
        <div class="drawer-fixed-header">
            <div class="drawer-header">
                <h6 class="drawer-header-title">Cart</h6>
                <div class="drawer-close">
                    <button type="button" class="drawer-close-btn">
                        <span class="drawer-close-icon">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="drawer-cart-empty collapse">
            <div class="drawer-scrollable">
                <h2>Your cart is currently empty</h2>
                <a href="/collection/all" class="btn btn-style2">Continue shopping</a>
            </div>
        </div>
        <div class="drawer-inner">
            <div class="drawer-scrollable">
                <ul class="cart-items">
                    <li class="cart-item">
                        <div class="cart-item-info">
                            <div class="cart-item-image">
                                <a href="product-template.html">
                                    <img src="img/menu/home-pro-banner1.jpg" class="img-fluid" alt="cart-1">
                                </a>
                            </div>
                            <div class="cart-item-details">
                                <div class="cart-item-name">
                                    <a href="product-template.html">Portable speaker</a>
                                </div>
                                <div class="cart-pro-info">
                                    <div class="cart-qty-price">
                                        <span>1</span>
                                        <span>×</span>
                                        <span class="price">$25.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="drawer-footer">
                <div class="drawer-block drawer-total">
                    <span class="drawer-subtotal">Subtotal</span>
                    <span class="drawer-totalprice">$25.00</span>
                </div>
                <div class="drawer-block drawer-cart-checkout">
                    <div class="cart-checkout-btn">
                        <a href="/cart" class="btn btn-style2">View cart</a>
                        <a href="/checkout" class="checkout btn btn-style2">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- cart-drawer end -->