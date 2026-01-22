@props([
    'settings' => \App\Models\Setting::all()->keyBy('key'),
    'product' => null, // Hacemos que el producto sea opcional
])
<?php

    // Valores SEO por defecto desde la configuración
    $defaultTitle = $settings['seo_title']->value ?? 'TecnnyGames';
    $defaultDesc = $settings['seo_description']->value ?? 'La mejor plantilla moderna y responsive para diferentes negocios o industrias de eCommerce.';
    $defaultKeywords = $settings['seo_keywords']->value ?? 'plantilla de comida, productos de panadería, html, plantilla html de comercio electrónico, plantas, comida orgánica, restaurante, árbol vivo, responsive, pizza, hamburguesa, muebles, móviles, relojes, electrónica, accesorios de computadoras, juguetes, joyería, accesorios de restaurante';

    // Valores específicos de la página
    $title = $defaultTitle;
    $description = $defaultDesc;
    $keywords = $defaultKeywords;
    $ogType = 'website';
    $ogImage = asset('img/favicon/favicon8.png'); // Imagen Open Graph por defecto

    if (isset($product)) {
        // --- SEO específico del producto ---
        $title = $product->seo_title ?: $product->name . ' | ' . $defaultTitle;
        $description = $product->seo_description ?: $product->short_description;
        $keywords = !empty($product->seo_keywords) ? (is_array($product->seo_keywords) ? implode(', ', $product->seo_keywords) : $product->seo_keywords) : $defaultKeywords;
        $ogType = 'product';
        $ogImage = $product->main_image_url; // Asumimos que existe un accesor 'main_image_url'
    }

?>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Metaetiquetas SEO -->
        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}" />
        <meta name="keywords" content="{{ $keywords }}" />
        <meta name="author" content="spacingtech_webify">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="{{ $ogType }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ $ogImage }}">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ $title }}">
        <meta property="twitter:description" content="{{ $description }}">
        <meta property="twitter:image" content="{{ $ogImage }}">

        <!-- Token CSRF -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/favicon8.png') }}">
        
        <!-- Estilos -->
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
        <link rel="stylesheet" type="text/css" href="{{ asset('css/product-page.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style3.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/other-pages.css') }}">

        @stack('styles')
    </head>
    <body>

        <x-layouts.mobile-menu />

        <x-layouts.header />

        <main id="main-content">
            {{ $slot }}
        </main>

        <x-layouts.footer />

        <x-cart-drawer />
        
        <x-product-quick-view />

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
                                    Correo Electrónico:<a href="mailto:{{ $settings['email']->value ?? 'demo@gmail.com' }}">{{ $settings['email']->value ?? 'demo@gmail.com' }}</a>
                                </p>
                                <p>
                                    Teléfono:<a href="tel:{{ $settings['phone']->value ?? '+1(23)456789' }}">{{ $settings['phone']->value ?? '+1 (23) 456 789' }}</a>
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
                        <div id="ask-question-modal-content">
                            <div class="ask-form">
                                <h6>Haz una pregunta</h6>
                                <form id="ask-question-form" action="{{ route('contact.ask-question') }}" method="post" class="contact-form">
                                    @csrf
                                    <div class="form-grp">
                                        <input type="text" name="name" required placeholder="Tu nombre*">
                                        <input type="text" name="phone" placeholder="Tu número de teléfono">
                                        <input type="email" name="email" required placeholder="Tu correo electrónico*">
                                        <textarea name="question" rows="4" required placeholder="Tu mensaje*"></textarea>
                                        <p>* Campos obligatorios</p>
                                        <button type="submit" class="btn-style2">Enviar ahora</button>
                                    </div>
                                </form>
                            </div>
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

        <script>
        $(document).ready(function() {

            // =========================================================================
            // LÓGICA DE VISTA RÁPIDA (QUICK VIEW) - MÉTODO ROBUSTO CON EVENTOS DE BOOTSTRAP
            // =========================================================================
            var quickViewModal = document.getElementById('quickview');
            quickViewModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Botón que disparó el modal
                var productSlug = button.getAttribute('data-product-slug');
                var modalBody = quickViewModal.querySelector('.modal-body');

                // 1. Inmediatamente muestra un spinner de carga en el modal
                modalBody.innerHTML = '<div class="d-flex justify-content-center align-items-center" style="min-height: 300px;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

                // 2. Realiza la llamada AJAX para obtener el contenido del producto
                $.ajax({
                    url: '/shop/quick-view/' + productSlug,
                    type: 'GET',
                    success: function(response) {
                        // 3. Cuando la llamada tiene éxito, inyecta el HTML recibido en el modal
                        modalBody.innerHTML = response;
                    },
                    error: function(xhr) {
                        // 4. Si hay un error, muestra un mensaje de error
                        console.error("Error al cargar la vista rápida:", xhr.responseText);
                        modalBody.innerHTML = '<div class="text-center p-5"><p class="text-danger">Error al cargar el producto. Por favor, inténtelo de nuevo más tarde.</p></div>';
                    }
                });
            });

            // =========================================================================
            // LÓGICA PARA AÑADIR AL CARRITO DESDE TARJETAS DE PRODUCTO
            // =========================================================================
            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();
                var $button = $(this);
                var productId = $button.data('product-id');

                $.ajax({
                    url: '{{ route("cart.store") }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'product_id': productId,
                        'quantity': 1 // Se añade 1 por defecto desde la tarjeta
                    },
                    beforeSend: function() {
                        $button.addClass('loading'); // Muestra feedback visual
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.cart-count').text(response.cart_count); // Actualiza el contador del header
                            window.refreshCartDrawer(window.openCartDrawer); // Refresca y abre el panel
                        } else {
                            alert(response.message || 'No se pudo añadir el producto.');
                        }
                    },
                    error: function(xhr) {
                        console.error("Error al añadir al carrito:", xhr.responseText);
                        alert('Hubo un problema de comunicación. Por favor, inténtalo de nuevo.');
                    },
                    complete: function() {
                        $button.removeClass('loading'); // Limpia el feedback visual
                    }
                });
            });

            // =========================================================================
            // LÓGICA PARA FORMULARIO "HAZ UNA PREGUNTA" (se mantiene intacta)
            // =========================================================================
            $('#ask-question-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var modalContent = $('#ask-question-modal-content');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            modalContent.html('<div class="text-center p-4"><i class="fas fa-check-circle fa-3x text-success mb-3"></i><p>' + response.message + '</p></div>');
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger"><ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        modalContent.find('.form-grp').prepend(errorHtml);
                    }
                });
            });
        });
        </script>
    </body>
</html>
