
<!-- header start -->
<header class="main-header">
    <div class="header-top-area" id="stickyheader">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="header-area">
                        <div class="header-element header-logo">
                            <div class="header-theme-logo">
                                <a href="/" class="theme-logo">
                                    <img src="{{ asset('img/logo/logo8.png') }}" class="img-fluid" alt="logo">
                                </a>
                            </div>
                        </div>
                        <div class="header-element header-menu">
                            <div class="mainmenu-content">
                                <div class="main-wrap">
                                    <ul class="main-menu">
                                        <li class="menu-link">
                                            <a href="/" class="link-title">
                                                <span class="sp-link-title">Inicio</span>
                                            </a>
                                        </li>
                                        <li class="menu-link">
                                            <a href="{{ route('shop.index') }}" class="link-title">
                                                <span class="sp-link-title">Tienda</span>
                                            </a>
                                        </li>
                                        <li class="menu-link">
                                            <a href="{{ route('shop.index') }}" class="link-title">
                                                <span class="sp-link-title">Colección</span>
                                            </a>
                                        </li>
                                        <li class="menu-link">
                                            <a href="{{ route('posts.index') }}" class="link-title">
                                                <span class="sp-link-title">Blog</span>
                                            </a>
                                        </li>
                                        <li class="menu-link">
                                            <a href="#" class="link-title">
                                                <span class="sp-link-title">Páginas</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menu-dropdown menu-sub collapse">
                                                <ul class="ul">
                                                    <li class="menusub-li">
                                                        <a href="/about-us" class="menusub-title">
                                                            <span class="sp-link-title">Sobre nosotros</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="#" class="menusub-title">
                                                            <span class="sp-link-title">Mi cuenta</span>
                                                            <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                        </a>
                                                        <div class="menusup-dropdown collapse">
                                                            <ul class="menusup-ul">
                                                                <li class="menusup-li">
                                                                    <a href="/order-history" class="menusup-title">
                                                                        <span class="sp-link-title">Pedidos</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/profile" class="menusup-title">
                                                                        <span class="sp-link-title">Perfil</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/pro-address" class="menusup-title">
                                                                        <span class="sp-link-title">Dirección</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/pro-tickets" class="menusup-title">
                                                                        <span class="sp-link-title">Mis tickets</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/billing-info" class="menusup-title">
                                                                        <span class="sp-link-title">Información de facturación</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/track-page" class="menusup-title">
                                                                        <span class="sp-link-title">Seguimiento de pedido</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/order-complete" class="menusup-title">
                                                                        <span class="sp-link-title">Pedido completado</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/contact-us" class="menusub-title">
                                                            <span class="sp-link-title">Contáctanos</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/checkout-style" class="menusub-title">
                                                            <span class="sp-link-title">Pagar</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="#" class="menusub-title">
                                                            <span class="sp-link-title">Características</span>
                                                            <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                        </a>
                                                        <div class="menusup-dropdown collapse">
                                                            <ul class="menusup-ul">
                                                                <li class="menusup-li">
                                                                    <a href="/cancellation" class="menusup-title">
                                                                        <span class="sp-link-title">Cancelación</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/cart-page" class="menusup-title">
                                                                        <span class="sp-link-title">Página del carrito</span>
                                                                    </a>
                                                                </li>
                                                                <li class="menusup-li">
                                                                    <a href="/sitemap" class="menusup-title">
                                                                        <span class="sp-link-title">Mapa del sitio</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/faq" class="menusub-title">
                                                            <span class="sp-link-title">Preguntas frecuentes</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/privacy-policy" class="menusub-title">
                                                            <span class="sp-link-title">Política de privacidad</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/payment-policy" class="menusub-title">
                                                            <span class="sp-link-title">Política de pago</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/shipping-policy" class="menusub-title">
                                                            <span class="sp-link-title">Política de envío</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/terms-condition" class="menusub-title">
                                                            <span class="sp-link-title">Términos y condiciones</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/return-policy" class="menusub-title">
                                                            <span class="sp-link-title">Política de devolución</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/404" class="menusub-title">
                                                            <span class="sp-link-title">Página 404</span>
                                                        </a>
                                                    </li>
                                                    <li class="menusub-li">
                                                        <a href="/coming-soon" class="menusub-title">
                                                            <span class="sp-link-title">Próximamente</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="header-element header-icon">
                            <div class="header-icon-block">
                                <ul class="shop-element">
                                    <li class="side-wrap search">
                                        <div class="search-box">
                                            <form action="{{ route('shop.search') }}" method="get" class="search-bar">
                                                <div class="form-search">
                                                    <input type="search" name="q" placeholder="Busca tu producto" class="search-input">
                                                    <button type="submit" class="search-btn"><span><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                    <li class="side-wrap search-wrap">
                                        <div class="search-wrapper">
                                            <a href="#searchmodal" data-bs-toggle="modal">
                                                <span class="search-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="side-wrap toggler-wrap">
                                        <div class="toggler-wrapper">
                                            <button class="toggler-btn">
                                            <span class="toggler-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></span>
                                            </button>
                                        </div>
                                    </li>
                                    <li class="side-wrap cart-wrap">
                                        <div class="cart-wrapper">
                                            <a href="javascript:void(0)" class="js-cart-drawer">
                                                <span class="cart-icon-count">
                                                    <span class="cart-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                                                    <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->