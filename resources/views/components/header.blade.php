<!-- notification-bar start -->
        <div class="notification-bar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <ul class="notification-content">
                            <li class="noti-wrap noti-email-wrap">
                                <div class="noti-email">
                                    <div class="emailtext">
                                        <p>Email:-</p>
                                        <p><a href="mailto:demo@demo.com" title="mailto:demo@demo.com">demo@demo.com</a></p>
                                    </div>
                                </div>
                            </li>
                            <li class="noti-wrap noti-text-wrap">
                                <div class="noti-text">
                                    <p>¡Oferta del día con 50% de descuento! <a href="{{ route('collection.index') }}">¡Compra ahora!</a></p>
                                </div>
                            </li>
                            <li class="noti-wrap noti-call-wrap">
                                <div class="noti-call">
                                    <p>Llama ahora:-<a href="{{ route('home') }}" title="tel:(+63) 0123 456 789">(+63) 0123 456 789</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- notification-bar end -->
        <!-- header start -->
        <header class="main-header">
            <div class="header-top-area" id="stickyheader">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="header-area">
                                <div class="header-element header-logo">
                                    <div class="header-theme-logo">
                                        <a href="{{ route('home') }}" class="theme-logo">
                                            <img src="{{ asset('img/logo/logo8.png') }}" class="img-fluid" alt="logo">
                                        </a>
                                    </div>
                                </div>
                                <div class="header-element header-menu">
                                    <div class="mainmenu-content">
                                        <div class="main-wrap">
                                            <ul class="main-menu">
                                                <li class="menu-link">
                                                    <a href="{{ route('home') }}" class="link-title">
                                                        <span class="sp-link-title">Inicio</span>
                                                    </a>
                                                </li>
                                                <li class="menu-link">
                                                    <a href="{{ route('collection.index') }}" class="link-title">
                                                        <span class="sp-link-title">Tienda</span>
                                                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                    </a>
                                                    <div class="menu-dropdown menu-mega collapse">
                                                        <ul class="ul container p-0">
                                                            <li class="menumega-li">
                                                                <a href="{{ route('collection.index') }}" class="menumega-title">
                                                                    <span class="sp-link-title">Auriculares</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                                </a>
                                                                <div class="menumegasup-dropdown collapse">
                                                                    <ul class="menumegasup-ul">
                                                                        <li class="menumegasup-li">
                                                                             <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Teléfono inteligente 5G</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Altavoces Bluetooth</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Ordenador Dell</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Portátil HP I5</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Cámara portátil</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menumega-li">
                                                                <a href="{{ route('collection.index') }}" class="menumega-title">
                                                                    <span class="sp-link-title">Proyector</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                                </a>
                                                                <div class="menumegasup-dropdown collapse">
                                                                    <ul class="menumegasup-ul">
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Reloj inteligente</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Volante de carreras</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Cámara portátil</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Portátil HP I5</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.category.juice_machine') }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Mando de juego</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menumega-li">
                                                                <a href="{{ route('collection.index') }}" class="menumega-title">
                                                                    <span class="sp-link-title">Smart TV</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                                </a>
                                                                <div class="menumegasup-dropdown collapse">
                                                                    <ul class="menumegasup-ul">
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.category.earbuds') }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Altavoces Bluetooth</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                             <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Tableta inteligente 5G</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Altavoces Bluetooth</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Ordenador Dell</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.category.pendrive') }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Mando de juego</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menumega-li">
                                                                <a href="{{ route('collection.index') }}" class="menumega-title">
                                                                    <span class="sp-link-title">Smartphone</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                                </a>
                                                                <div class="menumegasup-dropdown collapse">
                                                                    <ul class="menumegasup-ul">
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Cámara portátil</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Cámara de dron</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Volante de carreras</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Altavoces Bluetooth</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menumegasup-li">
                                                                            <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                                                <span class="sp-link-title">Nuevos auriculares </span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="menu-link">
                                                    <a href="{{ route('collection.index') }}" class="link-title">
                                                        <span class="sp-link-title">Colección</span>
                                                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                    </a>
                                                    <div class="menu-dropdown menu-banner collapse">
                                                        <ul class="ul container p-0">
                                                            <li class="menubanner-li">
                                                                <div class="menubanner-img">
                                                                    <a href="{{ route('collection.index') }}" class="collection-img banner-img">
                                                                        <img src="{{ asset('img/menu/home8-menu-banner.jpg') }}" class="img-fluid" alt="menu-banner1">
                                                                    </a>
                                                                    <a href="{{ route('collection.index') }}" class="collection-title">
                                                                        <span>Portátil</span>
                                                                    </a>
                                                                </div>
                                                            </li>
                                                            <li class="menubanner-li">
                                                                <div class="menubanner-img">
                                                                    <a href="{{ route('collection.index') }}" class="collection-img banner-img">
                                                                        <img src="{{ asset('img/menu/home8-menu-banner2.jpg') }}" class="img-fluid" alt="menu-banner2">
                                                                    </a>
                                                                    <a href="{{ route('collection.index') }}" class="collection-title">
                                                                        <span>Cámara</span>
                                                                    </a>
                                                                </div>
                                                            </li>
                                                            <li class="menubanner-li">
                                                                <div class="menubanner-img">
                                                                    <a href="{{ route('collection.index') }}" class="collection-img banner-img">
                                                                        <img src="{{ asset('img/menu/home8-menu-banner3.jpg') }}" class="img-fluid" alt="menu-banner3">
                                                                    </a>
                                                                    <a href="{{ route('collection.index') }}" class="collection-title">
                                                                        <span>Escritorio</span>
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                                <li class="menu-link">
                                                    <a href="{{ route('blog.grid.index') }}" class="link-title">
                                                        <span class="sp-link-title">Blog</span>
                                                    </a>
                                                </li>
                                                <li class="menu-link">
                                                    <a href="{{ route('page.about_us') }}" class="link-title">
                                                        <span class="sp-link-title">Page</span>
                                                        <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                                    </a>
                                                    <div class="menu-dropdown menu-sub collapse">
                                                        <ul class="ul">
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.about_us') }}" class="menusub-title">
                                                                    <span class="sp-link-title">About us</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                                </a>
                                                                <div class="menusup-dropdown collapse">
                                                                    <ul class="menusup-ul">
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('page.about_us') }}" class="menusup-title">
                                                                                <span class="sp-link-title">About us</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.about_us') }}" class="menusub-title">
                                                                    <span class="sp-link-title">My account</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                                </a>
                                                                <div class="menusup-dropdown collapse">
                                                                    <ul class="menusup-ul">
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('account.orders') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Order</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('account.profile') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Profile</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('account.addresses') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Address</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('wishlist.pro') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Wishlist</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('account.tickets') }}" class="menusup-title">
                                                                                <span class="sp-link-title">My tickets</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('account.billing') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Billing info</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('order.track') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Track page</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('checkout.complete') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Order complete</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.contact_us') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Contact us</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                                </a>
                                                                <div class="menusup-dropdown collapse">
                                                                    <ul class="menusup-ul">
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('page.contact_us') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Contact us</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.contact_us') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Checkout</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                                </a>
                                                                <div class="menusup-dropdown collapse">
                                                                    <ul class="menusup-ul">
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('checkout.index') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Checkout style 1</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.contact_us') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Features</span>
                                                                    <span class="menu-arrow"><i class="fa-solid fa-angle-right"></i></span>
                                                                </a>
                                                                <div class="menusup-dropdown collapse">
                                                                    <ul class="menusup-ul">
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('page.cancellation') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Cancellation</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('cart.index') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Cart page</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('wishlist.index') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Wishlist product</span>
                                                                            </a>
                                                                        </li>
                                                                        <li class="menusup-li">
                                                                            <a href="{{ route('page.sitemap') }}" class="menusup-title">
                                                                                <span class="sp-link-title">Sitemap</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.faq') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Faq's</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.privacy_policy') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Privacy policy</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.payment_policy') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Payment policy</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.shipping_policy') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Shipping policy</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.terms_condition') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Terms &amp; condition</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.return_policy') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Return policy</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.404') }}" class="menusub-title">
                                                                    <span class="sp-link-title">404 page</span>
                                                                </a>
                                                            </li>
                                                            <li class="menusub-li">
                                                                <a href="{{ route('page.coming_soon') }}" class="menusub-title">
                                                                    <span class="sp-link-title">Coming soon</span>
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
                                                    <form action="{{ route('search.index') }}" method="get" class="search-bar">
                                                        <div class="form-search">
                                                            <input type="search" name="q" placeholder="Find your search" class="search-input">
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
                                            <li class="side-wrap user-wrap">
                                                <div class="user-wrapper">
                                                    <a class="javascript:void(0)" data-bs-toggle="collapse" href="#store-account" aria-expanded="false">
                                                        <span class="user-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></span>
                                                    </a>
                                                    <div class="user-drower collapse" id="store-account" style="">
                                                        <a href="{{ route('auth.login') }}">Login</a>
                                                        <a href="{{ route('auth.register') }}">Register</a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="side-wrap wishlist-wrap">
                                                <div class="wishlist-wrapper">
                                                    <a href="{{ route('wishlist.empty') }}">
                                                        <span class="wishlist-icon-count">
                                                            <span class="wishlist-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span>
                                                            <span class="wishlist-count">0</span>
                                                        </span>
                                                    </a>
                                                </div>
                                            </li>
                                            <li class="side-wrap cart-wrap">
                                                <div class="cart-wrapper">
                                                    <a href="javascript:void(0)" class="js-cart-drawer">
                                                        <span class="cart-icon-count">
                                                            <span class="cart-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></span>
                                                            <span class="cart-count">4</span>
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