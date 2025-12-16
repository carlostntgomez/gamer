<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A best stylish, creative, modern responsive template for different eCommerce business or industries." />
        <meta name="keywords" content="food template, bakery products, html, eCommerce html template,plants, organic food, restaurant, live tree, responsive, pizza, burger, furniture, mobile, watches, electronics, computers accessories, toys, jewellery, restaurant accessories" />
        <meta name="author" content="spacingtech_webify">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- title -->
        <title>Electon - The Electronics eCommerce Bootstrap Template</title>
        <!-- favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/favicon8.png') }}">
        <!-- bootstrap css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-icons.css') }}">
        <!-- magnific-popup css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/magnific-popup.css') }}">
        <!-- fontawesome css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/all.min.css') }}">
        <!--fether css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/feather.css') }}">
        <!-- animate css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
        <!-- owl-carousel css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
        <!-- swiper css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper-bundle.min.css') }}">
        <!-- slick slider css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
        <!-- collection css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/collection.css') }}">
        <!-- blog css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/blog.css') }}">
        <!-- other-pages css -->
        <link rel="stylesheet" type="text/css" href= "{{ asset('css/other-pages.css') }}">
        <!-- product-page css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/product-page.css') }}">
        <!-- style css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style3.css') }}">
    </head>
    <body>
        <x-header />

        <main id="main-content">
            {{ $slot }}
        </main>

        <x-footer />

        <!-- mobile-menu start -->
        <div class="mobile-menu" id="mobile-menu">
            <div class="mobile-contents">
                <div class="menu-close">
                    <button class="menu-close-btn">
                    <span class="menu-close-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
                    </button>
                </div>
                <div class="menu-toggle">
                    <a href="#resp-main" class="toggle-text" data-bs-toggle="collapse" aria-expanded="true">
                        <span class="menu-icon"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></span>
                        <span class="menu-title">Menu</span>
                    </a>
                </div>
                <div class="mobilemenu-content collapse show" id="resp-main">
                    <div class="main-wrap">
                        <ul class="main-menu">
                            <li class="menu-link">
                                <a href="#menu-single" class="link-title" data-bs-toggle="collapse" aria-expanded="false">
                                    <span class="sp-link-title">Home</span>
                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                                <div class="menu-dropdown menu-single collapse show" id="menu-single">
                                    <ul class="ul">
                                        <li class="menusingle-li">
                                            <a href="{{ route('home') }}" class="menusingle-title">
                                                <span class="sp-link-title">Home 01</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-link">
                                <a href="#menu-mega" class="link-title" data-bs-toggle="collapse" aria-expanded="false">
                                    <span class="sp-link-title">Shop</span>
                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                                <div class="menu-dropdown menu-mega collapse" id="menu-mega">
                                    <ul class="ul container p-0">
                                        <li class="menumega-li">
                                            <a href="#menumega-sup1" class="menumega-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Earphone</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menumegasup-dropdown collapse" id="menumega-sup1">
                                                <ul class="menumegasup-ul">
                                                    <li class="menumegasup-li">
                                                         <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">5G smart phone</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Bluetooth speakers</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Dell computer</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">HP laptop I5</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Portable camera</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="menumega-li">
                                            <a href="#menumega-sup2" class="menumega-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Projector</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menumegasup-dropdown collapse" id="menumega-sup2">
                                                <ul class="menumegasup-ul">
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Smart watch</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Racing wheel</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Portable camera</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">HP laptop I5</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.category.juice_machine') }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Game controller</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="menumega-li">
                                            <a href="#menumega-sup3" class="menumega-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Smart TV</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menumegasup-dropdown collapse" id="menumega-sup3">
                                                <ul class="menumegasup-ul">
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.category.earbuds') }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Bluetooth speakers</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                         <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">5G smart tablet</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Bluetooth speakers</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Dell computer</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.category.pendrive') }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Game controller</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="menumega-li">
                                            <a href="#menumega-sup4" class="menumega-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Smartphone</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menumegasup-dropdown collapse" id="menumega-sup4">
                                                <ul class="menumegasup-ul">
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Portable camera</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Drone camera</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Racing wheel</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">Bluetooth speakers</span>
                                                        </a>
                                                    </li>
                                                    <li class="menumegasup-li">
                                                        <a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="menumegasup-title">
                                                            <span class="sp-link-title">New headphones </span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-link">
                                <a href="#menu-collection-banner" class="link-title" data-bs-toggle="collapse" aria-expanded="false">
                                    <span class="sp-link-title">Collection</span>
                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                                <div class="menu-dropdown menu-banner collapse" id="menu-collection-banner">
                                    <ul class="ul container p-0">
                                        <li class="menubanner-li">
                                            <div class="menubanner-img">
                                                <a href="{{ route('collection.index') }}" class="collection-img banner-img">
                                                    <img src="{{ asset('img/menu/home8-menu-banner.jpg') }}" class="img-fluid" alt="menu-banner1">
                                                </a>
                                                <a href="{{ route('collection.index') }}" class="collection-title">
                                                    <span>Laptop</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="menubanner-li">
                                            <div class="menubanner-img">
                                                <a href="{{ route('collection.index') }}" class="collection-img banner-img">
                                                    <img src="{{ asset('img/menu/home8-menu-banner2.jpg') }}" class="img-fluid" alt="menu-banner2">
                                                </a>
                                                <a href="{{ route('collection.index') }}" class="collection-title">
                                                    <span>Desktop</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="menubanner-li">
                                            <div class="menubanner-img">
                                                <a href="{{ route('collection.index') }}" class="collection-img banner-img">
                                                    <img src="{{ asset('img/menu/home8-menu-banner3.jpg') }}" class="img-fluid" alt="menu-banner3">
                                                </a>
                                                <a href="{{ route('collection.index') }}" class="collection-title">
                                                    <span>Camera</span>
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-link">
                                <a href="{{ route('blog.index') }}" class="link-title">
                                    <span class="sp-link-title">Blog</span>
                                </a>
                            </li>
                            <li class="menu-link">
                                <a href="#menu-sub" class="link-title" data-bs-toggle="collapse" aria-expanded="false">
                                    <span class="sp-link-title">Page</span>
                                    <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                </a>
                                <div class="menu-dropdown menu-sub collapse" id="menu-sub">
                                    <ul class="ul">
                                        <li class="menusub-li">
                                            <a href="#about-us" class="menusub-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">About us</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menusup-dropdown collapse" id="about-us">
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
                                            <a href="#account" class="menusub-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">My account</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menusup-dropdown collapse" id="account">
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
                                            <a href="#contact" class="menusub-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Contact us</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menusup-dropdown collapse" id="contact">
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
                                            <a href="#checkout" class="menusub-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Checkout</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menusup-dropdown collapse" id="checkout">
                                                <ul class="menusup-ul">
                                                    <li class="menusup-li">
                                                        <a href="{{ route('checkout.style1') }}" class="menusup-title">
                                                            <span class="sp-link-title">Checkout style 1</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="menusub-li">
                                            <a href="#features" class="menusub-title" data-bs-toggle="collapse" aria-expanded="false">
                                                <span class="sp-link-title">Features</span>
                                                <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                                            </a>
                                            <div class="menusup-dropdown collapse" id="features">
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
        </div>
        <!-- mobile-menu end -->

        <!-- jquery js -->
        <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
        <!-- bootstrap js -->
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <!-- magnific-popup js -->
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <!-- owl-carousel js -->
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <!-- swiper-slider js -->
        <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
        <!-- slick js -->
        <script src="{{ asset('js/slick.min.js') }}"></script>
        <!-- waypoints js -->
        <script src="{{ asset('js/waypoints.min.js') }}"></script>
        <!-- counter js -->
        <script src="{{ asset('js/counter.js') }}"></script>
        <!-- foo-typewriter js -->
        <script src="{{ asset('js/typewriter.js') }}"></script>
        <!-- main js -->
        <script src="{{ asset('js/main.js') }}"></script>
    </body>
</html>