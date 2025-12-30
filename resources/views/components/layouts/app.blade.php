<?php

// Determine SEO values based on whether a product is passed
$title = isset($product) && $product->seo_title ? $product->seo_title : 'Electon - The Electronics eCommerce Bootstrap Template';
$description = isset($product) && $product->seo_description ? $product->seo_description : 'A best stylish, creative, modern responsive template for different eCommerce business or industries.';
$keywords = isset($product) && !empty($product->seo_keywords) ? (is_array($product->seo_keywords) ? implode(', ', $product->seo_keywords) : $product->seo_keywords) : 'food template, bakery products, html, eCommerce html template,plants, organic food, restaurant, live tree, responsive, pizza, burger, furniture, mobile, watches, electronics, computers accessories, toys, jewellery, restaurant accessories';

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- SEO Meta Tags -->
        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}" />
        <meta name="keywords" content="{{ $keywords }}" />
        <meta name="author" content="spacingtech_webify">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/favicon8.png') }}">
        
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-icons.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/feather.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.carousel.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper-bundle.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/collection.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/blog.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/other-pages.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/product-page.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style3.css') }}">

        @stack('styles')
    </head>
    <body>

        <x-layouts.header />

        <main id="main-content">
            {{ $slot }}
        </main>

        <x-layouts.footer />

        <x-cart-drawer />
        <div class="bg-screen"></div>

        <div class="modal fade deliver-modal" id="deliver-modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="pop-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="feather-x"></i>
                        </button>
                        <div class="delivery-block">
                            <div class="space-block">
                                <h4>Envío</h4>
                                <p>Todos los pedidos se envían con UPS Express.</p>
                                <p>Envío gratuito para pedidos superiores a 250 USD.</p>
                                <p>Todos los pedidos se envían con un número de seguimiento de UPS.</p>
                            </div>
                            <div class="space-block">
                                <h4>Devoluciones</h4>
                                <p>Los artículos devueltos dentro de los 14 días de su fecha de envío original en las mismas condiciones que nuevos serán elegibles para un reembolso completo o crédito en la tienda.</p>
                                <p>Los reembolsos se realizarán a la forma de pago original utilizada para la compra.</p>
                                <p>El cliente es responsable de los gastos de envío al realizar devoluciones y los gastos de envío/manejo de la compra original no son reembolsables.</p>
                                <p>Todos los artículos en oferta son compras finales.</p>
                            </div>
                            <div class="space-block">
                                <h4>Ayuda</h4>
                                <p>Ponte en contacto si tienes otras preguntas y/o inquietudes.</p>
                                <p>
                                    Correo Electrónico:<a href="mailto:contact@domain.com">demo@gmail.com</a>
                                </p>
                                <p>
                                    Teléfono:<a href="tel:+1(23)456789">+1 (23) 456 789</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade que-modal" id="que-modal" aria-modal="true" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="pop-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="feather-x"></i>
                        </button>
                        <div class="ask-form">
                            <h6>Haz una pregunta</h6>
                            <form method="post" class="contact-form">
                                <div class="form-grp">
                                    <input type="text" name="contact[name]" required="" placeholder="Tu nombre*">
                                    <input type="text" name="contact[phone]" placeholder="Tu número de teléfono">
                                    <input type="email" name="contact[email]" required="" placeholder="Tu correo electrónico*">
                                    <textarea name="contact[question]" rows="4" required="" placeholder="Tu mensaje*"></textarea>
                                    <p>* Campos obligatorios</p>
                                    <button type="submit" class="btn-style2">Enviar ahora</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.6.3.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('js/slick.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
        <script src="{{ asset('js/waypoints.min.js') }}"></script>
        <script src="{{ asset('js/counter.js') }}"></script>
        <script src="{{ asset('js/typewriter.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="{{ asset('js/cart.js') }}"></script>

        @stack('scripts')
    </body>
</html>