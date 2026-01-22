<x-layouts.app>
    @php
        $cart = session('cart', []);
        $subtotal = array_reduce($cart, fn($carry, $item) => $carry + $item['price'] * $item['quantity'], 0);
        $cartCount = count($cart);
    @endphp

    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="col">
                <div class="row">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li">
                                <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                            </li>
                            <li class="breadcrumb-li">
                                <span class="breadcrumb-text">Tu carrito de compras</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- cart-page start -->
    <section class="cart-page section-ptb">
        <div class="container">
            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            @if ($cartCount > 0)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="cart-page-wrap">
                            <div class="cart-wrap-info">
                                <div class="cart-item-wrap">
                                    <div class="cart-title">
                                        <h6 data-animate="animate__fadeInUp">Mi carrito:</h6>
                                        <span class="cart-count" data-animate="animate__fadeInUp">
                                            <span class="cart-counter">{{ $cartCount }}</span>
                                            <span class="cart-item-title">Productos</span>
                                        </span>
                                    </div>
                                    <div class="item-wrap">
                                        {{-- INICIO DE LA SECCIÓN CORREGIDA --}}
                                        @foreach($cart as $id => $details)
                                            @php
                                                $product = \App\Models\Product::find($id);
                                                $productUrl = $product ? route('shop.show', $product->slug) : '#';
                                                $imageUrl = $details['image'] ? Storage::url($details['image']) : url('/images/placeholder-product.png');
                                            @endphp
                                            {{-- Se restaura la estructura original de la plantilla para la página del carrito --}}
                                            <ul class="cart-wrap cart-item" data-id="{{ $id }}">
                                                <li class="item-info">
                                                    <div class="item-img">
                                                        <a href="{{ $productUrl }}" data-animate="animate__fadeInUp">
                                                            <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $details['name'] }}">
                                                        </a>
                                                    </div>
                                                    <div class="item-text">
                                                        <a href="{{ $productUrl }}" data-animate="animate__fadeInUp">{{ $details['name'] }}</a>
                                                        <span class="item-option" data-animate="animate__fadeInUp">
                                                            <span class="item-price">${{ number_format($details['price'], 2, ',', '.') }}</span>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="item-qty">
                                                    <div class="product-quantity-action">
                                                        <div class="product-quantity" data-animate="animate__fadeInUp">
                                                            <div class="cart-plus-minus">
                                                                <button type="button" class="dec qtybutton minus js-qty-adjust" data-id="{{ $id }}" data-action="decrease"><i class="fa-solid fa-minus"></i></button>
                                                                <input type="text" name="quantity" value="{{ $details['quantity'] }}" class="js-qty-num" readonly>
                                                                <button type="button" class="inc qtybutton plus js-qty-adjust" data-id="{{ $id }}" data-action="increase"><i class="fa-solid fa-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="item-remove">
                                                        <span class="remove-wrap" data-animate="animate__fadeInUp">
                                                             {{-- Se reemplaza el texto "Eliminar" por el icono de la plantilla --}}
                                                            <a href="javascript:void(0)" class="text-danger cart-remove" data-id="{{ $id }}" style="font-size: 1.2rem;"><i class="bi bi-trash"></i></a>
                                                        </span>
                                                    </div>
                                                </li>
                                                <li class="item-price" data-animate="animate__fadeInUp">
                                                    <span class="amount full-price">${{ number_format($details['price'] * $details['quantity'], 2, ',', '.') }}</span>
                                                </li>
                                            </ul>
                                        @endforeach
                                        {{-- FIN DE LA SECCIÓN CORREGIDA --}}
                                    </div>
                                    <div class="cart-buttons" data-animate="animate__fadeInUp">
                                        <a href="{{ route('shop.index') }}" class="btn-style2">Continuar comprando</a>
                                        <a href="#" class="btn-style2" onclick="event.preventDefault(); document.getElementById('clear-cart-form').submit();">Limpiar carrito</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-info-wrap">
                            <div class="cart-total-wrap cart-info">
                                <div class="cart-total">
                                    <div class="total-amount" data-animate="animate__fadeInUp">
                                        <h6 class="total-title">Subtotal</h6>
                                        <span class="amount total-price" id="cart-subtotal">${{ number_format($subtotal, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="total-amount" data-animate="animate__fadeInUp">
                                        <h6 class="total-title">Total</h6>
                                        <span class="amount total-price" id="cart-total">${{ number_format($subtotal, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="proceed-to-checkout" data-animate="animate__fadeInUp">
                                        <p style="font-size: 12px; color: #666; margin-top: 15px;">Los impuestos y el envío se calculan en el checkout.</p>
                                        <a href="{{ route('checkout.index') }}" class="btn btn-style2">Finalizar Compra</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form id="clear-cart-form" action="{{ route('cart.clear') }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            @else
                <div class="row">
                    <div class="col">
                        <div class="empty-cart-page">
                            <div class="section-capture">
                                <div class="section-title">
                                    <h2 data-animate="animate__fadeInUp"><span>Carrito vacío</span></h2>
                                    <p data-animate="animate__fadeInUp">Lo sentimos, tu carrito no tiene productos actualmente.</p>
                                    <p data-animate="animate__fadeInUp">Continúa navegando
                                        <a href="{{ route('shop.index') }}">aquí</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- cart-page end -->

    <!-- product-tranding start -->
    @if($relatedProducts->isNotEmpty())
    <section class="Trending-product bg-color section-ptb">
        <div class="collection-category">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <span class="sub-title" data-animate="animate__fadeInUp">Browse collection</span>
                                <h2><span data-animate="animate__fadeInUp">También te podría interesar</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="collection-wrap">
                            <div class="collection-slider swiper" id="Trending-product">
                                <div class="swiper-wrapper">
                                    @foreach ($relatedProducts as $product)
                                        <div class="swiper-slide" data-animate="animate__fadeInUp">
                                            <x-product-card :product="$product" />
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                             <div class="swiper-buttons">
                                <div class="swiper-buttons-wrap">
                                    <button class="swiper-prev swiper-prev-Trending"><span><i class="feather-arrow-left"></i></span></button>
                                    <button class="swiper-next swiper-next-Trending"><span><i class="feather-arrow-right"></i></span></button>
                                </div>
                            </div>
                            <div class="swiper-dots">
                                <div class="swiper-pagination swiper-pagination-Trending"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- product-tranding end -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializar el carrusel de productos relacionados
            if (document.getElementById('Trending-product')) {
                new Swiper('#Trending-product', {
                    slidesPerView: 4,
                    spaceBetween: 30,
                    loop: true,
                    navigation: {
                        nextEl: '.swiper-next-Trending',
                        prevEl: '.swiper-prev-Trending',
                    },
                    pagination: {
                        el: '.swiper-pagination-Trending',
                        clickable: true,
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1,
                            spaceBetween: 15,
                        },
                        480: {
                            slidesPerView: 2,
                            spaceBetween: 15,
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 20,
                        },
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        }
                    }
                });
            }
        });
    </script>
</x-layouts.app>
