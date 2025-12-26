<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        <!-- jquery-ui css -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
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

        @stack('styles')
    </head>
    <body>

        <x-layouts.header />

        <!-- main start -->
        <main id="main-content">
            {{ $slot }}
        </main>
        <!-- main end -->

        <x-layouts.footer />

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
        <!-- jquery-ui js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <!-- waypoints js -->
        <script src="{{ asset('js/waypoints.min.js') }}"></script>
        <!-- counter js -->
        <script src="{{ asset('js/counter.js') }}"></script>
        <!-- foo-typewriter js -->
        <script src="{{ asset('js/typewriter.js') }}"></script>
        <!-- main js -->
        <script src="{{ asset('js/main.js') }}"></script>

        @stack('scripts')
    </body>
</html>
