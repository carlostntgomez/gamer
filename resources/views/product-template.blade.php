blade
@section('title', $product->seo_title)
@section('meta_description', $product->seo_description)
@section('meta_keywords', implode(',', (array)$product->seo_keywords))
<x-app-layout>
    <!-- main section start-->
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="col">
                    <div class="row">
                        <div class="breadcrumb-index">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-ul">
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">{{ $product->name }}</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- pro-detail-page-tab start -->
        <section class="product-details-page pro-style4 bg-color section-pt">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="pro-details-pos pro-details-left-pos">
                            <!-- Product slider start -->
                            <div class="product-detail-slider product-details-lr product-details product-details-sticky">
                                <!-- Product slider start -->
                                <div class="product-detail-img product-detail-img-left">
                                    <div class="product-img-top">
                                        <button class="full-view"><i class="bi bi-arrows-fullscreen"></i></button>
                                        <!-- blog slick slider start -->
                                        <div class="style4-slider-big slick-slider">
                                            @foreach ($product->images as $image)
                                            <div class="slick-slide">
                                                <a href="{{ Storage::url($image) }}" class="product-single">
                                                    <figure class="zoom" onmousemove="zoom(event)" style="background-image: url('{{ Storage::url($image) }}');">
                                                        <img src="{{ Storage::url($image) }}" class="img-fluid" alt="{{ $product->name }}">
                                                    </figure>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- blog slick slider end -->
                                    <!-- small slick-slider start -->
                                    <div class="pro-slider">
                                        <div class="style4-slider-small pro-detail-slider">
                                            @foreach ($product->images as $image)
                                            <div class="slick-slide">
                                                <a href="javascript:void(0)" class="product-single--thumbnail">
                                                    <img src="{{ Storage::url($image) }}" class="img-fluid" alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- small slick-slider end -->
                                </div>
                                <!-- Product slider end -->
                            </div>
                            <!-- peoduct detail end -->
                            <div class="product-details-wrap product-details-lr product-details">
                                <div class="product-details-info">
                                    <div class="pro-nprist">
                                        <div class="product-info">
                                            <!-- product-title start -->
                                            <div class="product-title">
                                                <h2>{{ $product->name }}</h2>
                                            </div>
                                            <!-- product-title end -->
                                        </div>
                                        <div class="product-info">
                                            <!-- product-rating start -->
                                            <div class="product-ratting">
                                                <span class="pro-ratting">
                                                    @php
                                                        $averageRating = $averageRating ?? 0; // Use $averageRating from controller
                                                        $fullStars = floor($averageRating);
                                                        $halfStar = ($averageRating - $fullStars) >= 0.5 ? 1 : 0;
                                                        $emptyStars = 5 - $fullStars - $halfStar;
                                                    @endphp
                                                    @for ($i = 0; $i < $fullStars; $i++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                    @if ($halfStar)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @endif
                                                    @for ($i = 0; $i < $emptyStars; $i++)
                                                        <i class="far fa-star"></i> {{-- Assuming far fa-star for empty stars --}}
                                                    @endfor
                                                </span>
                                                <span class="spr-badge-caption">
                                                    @if ($reviews->count() > 0)
                                                        ({{ $reviews->count() }} Reseñas)
                                                    @else
                                                        Sin reseñas
                                                    @endif
                                                </span>
                                            </div>
                                            <!-- product-rating end -->
                                        </div>
                                        <div class="product-info">
                                            <div class="pro-prlb pro-sale">
                                                <div class="price-box">
                                                    <span class="new-price">${{ number_format($product->price, 2) }} </span>
                                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                                        <span class="old-price">${{ number_format($product->sale_price, 2) }} </span>
                                                        @php
                                                            $discountPercentage = (($product->price - $product->sale_price) / $product->price) * 100;
                                                        @endphp
                                                        <span class="percent-count">{{ round($discountPercentage) }}%</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-inventory">
                                                @if ($product->stock_quantity > 0) {{-- Changed to stock_quantity --}}
                                                    <div class="stock-inventory stock-more">
                                                        <p class="text-success">¡Date prisa! ¡Solo quedan
                                                            <span class="available-stock bg-success">{{ $product->stock_quantity }}</span> {{-- Changed to stock_quantity --}}
                                                            productos en stock!
                                                        </p>
                                                    </div>
                                                    <div class="product-variant">
                                                        <h6>Disponibilidad:</h6>
                                                        <span class="stock-qty in-stock text-success">
                                                            <span>En stock<i class="bi bi-check2"></i></span>
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="stock-inventory stock-zero">
                                                        <p class="text-danger">¡Desafortunadamente, el producto está
                                                            <span class="available-stock bg-danger">Agotado</span>!
                                                        </p>
                                                    </div>
                                                    <div class="product-variant">
                                                        <h6>Disponibilidad:</h6>
                                                        <span class="stock-qty out-stock text-danger">
                                                            <span>Agotado</span>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="pro-detail-action">
                                                <form method="get" class="cart">
                                                    <div class="product-variant-option">
                                                        <div class="swatch-variant">
                                                                                                                        @if ($product->colors)
                                                                                                                        <div class="swatch clearfix Color">
                                                                                                                            <div class="header">
                                                                                                                                <h6>
                                                                                                                                <span>Color:</span>
                                                                                                                                <span class="data-value">{{ $product->colors[0] ?? '' }}</span>
                                                                                                                                </h6>
                                                                                                                            </div>
                                                                                                                            <div class="variant-wrap">
                                                                                                                                <div class="variant-property">
                                                                                                                                    @foreach ($product->colors as $color)
                                                                                                                                    <div class="swatch-element color {{ ucfirst($color) }}">
                                                                                                                                        <input type="radio" name="option-0" value="{{ $color }}" {{ $loop->first ? 'checked' : '' }}>
                                                                                                                                        <label>{{ ucfirst($color) }}</label>
                                                                                                                                    </div>
                                                                                                                                    @endforeach
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        @endif
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <form method="post" class="cart">
                                                <div class="pro-detail-button">
                                                    <div class="product-quantity-button">
                                                        <div class="product-quantity-action">
                                                            <h6>Cantidad:</h6>
                                                            <div class="product-quantity">
                                                                <div class="cart-plus-minus">
                                                                    <button class="dec qtybutton minus"><i class="feather-minus"></i></button>
                                                                    <input type="text" name="quantity" value="1">
                                                                    <button class="inc qtybutton plus"><i class="feather-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" onclick="location.href='{{ route('cart.index') }}'" class="btn add-to-cart ajax-spin-cart">
                                                        <span class="cart-title">Añadir al carrito</span>
                                                        </button>
                                                    </div>
                                                    <a href="{{ route('cart.empty') }}" class="btn btn-cart btn-theme">
                                                        <span>Comprar ahora</span>
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-actions">
                                                <!-- pro-deatail wishlist start -->
                                                <div class="pro-aff-che">
                                                    <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                        <span class="wishlist-icon action-wishlist tile-actions--btn wishlist-btn">
                                                            <span class="add-wishlist"><i class="bi bi-heart"></i></span>
                                                        </span>
                                                        <span class="wishlist-text">Lista de deseos</span>
                                                    </a>
                                                </div>
                                                <!-- pro-deatail wishlist end -->
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="form-group">
                                                <a href="#deliver-modal" data-bs-toggle="modal">Entrega y devolución</a>
                                                <a href="#que-modal" data-bs-toggle="modal">Hacer una pregunta</a>
                                            </div>
                                        </div>
                                        <div class="modal fade deliver-modal" id="deliver-modal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <button type="button" class="pop-close" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button>
                                                        <div class="delivery-block">
                                                            <div class="space-block">
                                                                <h4>Entrega</h4>
                                                                <p>Todos los pedidos se envían con UPS Express.</p>
                                                                <p>Envío siempre gratuito para pedidos superiores a 250 USD.</p>
                                                                <p>Todos los pedidos se envían con un número de seguimiento de UPS.</p>
                                                            </div>
                                                            <div class="space-block">
                                                                <h4>Devoluciones</h4>
                                                                <p>Los artículos devueltos dentro de los 14 días posteriores a su fecha de envío original en las mismas condiciones que nuevos serán elegibles para un reembolso completo o crédito de la tienda.</p>
                                                                <p>Los reembolsos se cargarán a la forma de pago original utilizada para la compra.</p>
                                                                <p>El cliente es responsable de los gastos de envío al realizar devoluciones y los gastos de envío/manipulación de la compra original no son reembolsables.</p>
                                                                <p>Todos los artículos en oferta son compras finales.</p>
                                                            </div>
                                                            <div class="space-block">
                                                                <h4>Ayuda</h4>
                                                                <p>Contáctanos si tienes alguna otra pregunta y/o inquietud.</p>
                                                                <p>Correo electrónico:<a href="mailto:contact@domain.com">demo@gmail.com</a></p>
                                                                <p>Teléfono:<a href="tel:+1(23)456789">+1 (23) 456 789</a></p>
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
                                                        <button type="button" class="pop-close" data-bs-dismiss="modal" aria-label="Close"><i
                                                        class="feather-x"></i></button>
                                                        <div class="product-form-list">
                                                            <div class="single-product-wrap">
                                                                <div class="product-image">
                                                                    <a class="pro-img" href="{{ route('collection.index') }}">
                                                                        <img class="img-fluid img1 resp-img1" src="{{ asset('img/product/home1-pro-5.jpg') }}"
                                                                        alt="p-1">
                                                                        <img class="img-fluid img2 resp-img2" src="{{ asset('img/product/home1-pro-6.jpg') }}"
                                                                        alt="p-2">
                                                                    </a>
                                                                </div>
                                                                <div class="product-content">
                                                                    <div class="pro-title-price">
                                                                        <h6><a href="{{ route('product.show', ['slug' => 'air-conditioner']) }}">Air conditioner</a></h6>
                                                                        <div class="product-price">
                                                                            <div class="price-box">
                                                                                <span class="new-price">$61.00</span>
                                                                                <span class="old-price">$54.00</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="ask-form">
                                                            <h6>Hacer una pregunta</h6>
                                                            <form method="post" class="new-question-form"> {{-- Changed class to new-question-form --}}
                                                                <input type="hidden" name="contact[product url]" value="">
                                                                <div class="form-grp">
                                                                    <input type="text" name="contact[name]" required="" placeholder="Tu nombre*">
                                                                    <input type="text" name="contact[phone]" placeholder="Tu número de teléfono">
                                                                    <input type="email" name="contact[email]" required="" placeholder="Tu correo electrónico*">
                                                                    <textarea name="contact[question]" rows="4" required=""
                                                                    placeholder="Tu mensaje*"></textarea>
                                                                    <p>* Campos obligatorios</p>
                                                                    <button type="submit" class="btn-style2">Enviar ahora</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <p><span>🚚</span> {{ $product->delivery_date_message ?? 'El artículo será entregado el o antes del' }} <span id="ten-days-ahead">{{ now()->addDays(10)->format('M j Y') }}</span></p>
                                        </div>
                                        <div class="product-info">
                                            <div class="product-sku">
                                                <h6>SKU:</h6>
                                                <span class="variant-sku">{{ $product->sku }}</span>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <div class="share-icons">
                                                <h6>Compartir:</h6>
                                                <div class="pro-social">
                                                    <ul class="social-icon">
                                                        <li class="facebook">
                                                            <a href="https://facebook.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"></path></svg></a>
                                                        </li>
                                                        <li class="twitter">
                                                            <a href="https://twitter.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg></a>
                                                        </li>
                                                        <li class="pinterest">
                                                            <a href="https://pinterest.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"></path></svg></a>
                                                        </li>
                                                        <li class="instagram">
                                                            <a href="https://instagram.com"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6 42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <section class="product-description-tab">
                                    <div class="product-tab" id="collapse-tab">
                                        <div class="tab">
                                            <a href="#collapse-description" class="tab-title collapsed" data-bs-toggle="collapse" aria-expanded="true" >
                                                <h6 class="tab-name">Descripción</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse show" id="collapse-description" data-bs-parent="#collapse-tab">
                                                <div class="product-description">
                                                    {!! $product->long_description !!} {{-- Changed to long_description --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <a href="#collapse-additional-info" class="tab-title collapsed" data-bs-toggle="collapse">
                                                <h6 class="tab-name">Información adicional</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse" id="collapse-additional-info" data-bs-parent="#collapse-tab">
                                                <div class="product-additional-info">
                                                    <table>
                                                        <tbody>
                                                            <tr class="product-info">
                                                                <th>Marca</th>
                                                                <td>{{ $product->brand->name ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr class="product-info">
                                                                <th>Tipo</th>
                                                                <td>{{ ucfirst(str_replace('_', ' ', $product->type->value)) ?? 'N/A' }}</td>
                                                            </tr>
                                                            @if ($product->additional_info)
                                                                @foreach ($product->additional_info as $key => $value)
                                                                    <tr class="product-info">
                                                                        <th>{{ $key }}</th>
                                                                        <td>{{ $value }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <a href="#collapse-other-content" class="tab-title collapsed" data-bs-toggle="collapse">
                                                <h6 class="tab-name">Especificaciones</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse" id="collapse-other-content" data-bs-parent="#collapse-tab">
                                                <div class="product-custom-content">
                                                        <table>
                                                            <tbody>
                                                                @if (!empty($product->specifications))
                                                                    @foreach ($product->specifications as $key => $value)
                                                                        <tr class="product-info">
                                                                            <th>{{ Str::title(str_replace('_', ' ', $key)) }}</th>
                                                                            <td>{{ $value }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr class="product-info">
                                                                        <td colspan="2">No hay especificaciones disponibles.</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <a href="#collapse-reviews" class="tab-title collapsed" data-bs-toggle="collapse">
                                                <h6 class="tab-name">Reseñas</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse" id="collapse-reviews" data-bs-parent="#collapse-tab">
                                                <div id="product-reviews">
                                                    <div class="spr-container">
                                                        <div class="spr-header">
                                                            <h2 class="spr-header-title">Opiniones de clientes</h2>
                                                            <div class="spr-summary rte">
                                                                <span class="spr-summary-caption">
                                                                    @if ($reviews->count() > 0)
                                                                        <span class="spr-summary-caption">Mostrando {{ $reviews->count() }} reseña(s)</span>
                                                                    @else
                                                                        <span class="spr-summary-caption">Aún no hay reseñas</span>
                                                                    @endif
                                                                </span>
                                                                <span class="spr-summary-actions">
                                                                    <a href="#add-review" data-bs-toggle="collapse" class="spr-summary-actions-newreview">Escribir una reseña</a>
                                                                </span>
                                                            </div>
                                                            <!-- product-rating end -->
                                                        </div>
                                                        <div class="spr-content">
                                                            @if ($reviews->count() > 0)
                                                                @foreach ($reviews as $review)
                                                                    <div class="spr-review">
                                                                        <div class="spr-review-header">
                                                                            <h3 class="spr-review-header-title">{{ $review->title }}</h3>
                                                                            <div class="spr-review-header-byline">
                                                                                <strong>{{ $review->author_name }}</strong> en {{ $review->created_at->format('d M, Y') }}
                                                                            </div>
                                                                            <div class="product-ratting">
                                                                                <span class="pro-ratting">
                                                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                                                        <i class="fas fa-star"></i>
                                                                                    @endfor
                                                                                    @for ($i = $review->rating; $i < 5; $i++)
                                                                                        <i class="far fa-star"></i>
                                                                                    @endfor
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="spr-review-body">
                                                                            <p>{{ $review->content }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                            <!-- spar-from start -->
                                                            <div class="spr-form collapse" id="add-review">
                                                                <form method="post" action="{{ route('reviews.store', $product->slug) }}" class="new-review-form">
                                                                    @csrf
                                                                    <h3 class="spr-form-title">Escribir una reseña</h3>
                                                                    <fieldset class="spr-form-contact">
                                                                        <div class="spr-form-contact-name">
                                                                            <label class="spr-form-label">Nombre</label>
                                                                            <input type="text" name="author_name" class="spr-form-input spr-form-input-text @error('author_name') is-invalid @enderror" placeholder="Tu nombre" value="{{ old('author_name') }}" required>
                                                                            @error('author_name')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="spr-form-contact-email">
                                                                            <label class="spr-form-label">Dirección de correo electrónico</label>
                                                                            <input type="email" name="author_email" class="spr-form-input spr-form-input-email @error('author_email') is-invalid @enderror" placeholder="john.smith@example.com" value="{{ old('author_email') }}" required>
                                                                            @error('author_email')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="spr-form-review">
                                                                        <div class="spr-form-review-rating">
                                                                            <label class="spr-form-label">Calificación</label>
                                                                            <div class="product-ratting rating-input"> {{-- Added rating-input class for JS --}}
                                                                                <input type="radio" id="star5" name="rating" value="5" {{ old('rating') == 5 ? 'checked' : '' }} required><label for="star5" title="5 stars" data-value="5"><i class="fas fa-star"></i></label>
                                                                                <input type="radio" id="star4" name="rating" value="4" {{ old('rating') == 4 ? 'checked' : '' }}><label for="star4" title="4 stars" data-value="4"><i class="fas fa-star"></i></label>
                                                                                <input type="radio" id="star3" name="rating" value="3" {{ old('rating') == 3 ? 'checked' : '' }}><label for="star3" title="3 stars" data-value="3"><i class="fas fa-star"></i></label>
                                                                                <input type="radio" id="star2" name="rating" value="2" {{ old('rating') == 2 ? 'checked' : '' }}><label for="star2" title="2 stars" data-value="2"><i class="fas fa-star"></i></label>
                                                                                <input type="radio" id="star1" name="rating" value="1" {{ old('rating') == 1 ? 'checked' : '' }}><label for="star1" title="1 star" data-value="1"><i class="fas fa-star"></i></label>
                                                                                {{-- Hidden input to actually store the selected rating value --}}
                                                                                {{-- Removed the hidden input for rating, as the radio buttons handle the 'rating' name directly --}}
                                                                            </div>
                                                                            @error('rating')
                                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="spr-form-review-title">
                                                                            <label class="spr-form-label">Título de la reseña</label>
                                                                            <input type="text" name="title" class="spr-form-input spr-form-input-text @error('title') is-invalid @enderror" placeholder="Dale un título a tu reseña" value="{{ old('title') }}" required>
                                                                            @error('title')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="spr-form-review-body">
                                                                            <label class="spr-form-label">Cuerpo de la reseña
                                                                                <span>
                                                                                    <span class="spr-form-review-body-charactersremaining">(1500)</span>
                                                                                </span>
                                                                            </label>
                                                                            <div class="spr-form-input">
                                                                                <textarea name="content" rows="4" class="spr-form-input spr-form-input-textarea @error('content') is-invalid @enderror" placeholder="Escribe tus comentarios aquí" required>{{ old('content') }}</textarea>
                                                                                @error('content')
                                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="spr-form-actions">
                                                                        <input type="submit" value="Enviar reseña" class="spr-button spr-button-primary button button-primary btn btn-primary">
                                                                    </fieldset>
                                                                </form>
                                                            </div>
                                                            <!-- spar-from end -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- peoduct detail end -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="video section-pt">
                            <div class="video-wrapper">
                                @if ($product->video_url)
                                <iframe src="{{ $product->video_url }}" allowfullscreen></iframe>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- pro-detail-page-tab end -->
        <!-- product-tranding start -->
        <section class="Trending-product bg-color section-ptb">
            <div class="collection-category">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="section-capture">
                                <div class="section-title">
                                    <span class="sub-title" data-animate="animate__fadeInUp">Explorar colección</span>
                                    <h2><span data-animate="animate__fadeInUp">Producto de tendencia</span></h2>
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
                                        @foreach ($trendingProducts as $trendingProduct)
                                            <div class="swiper-slide" data-animate="animate__fadeInUp">
                                                <div class="single-product-wrap">
                                                    <div class="product-image">
                                                        <a href="{{ route('product.show', ['slug' => $trendingProduct->slug]) }}" class="pro-img">
                                                            <img src="{{ Storage::url($trendingProduct->main_image_path) }}" class="img-fluid img1 mobile-img1" alt="{{ $trendingProduct->name }}">
                                                            {{-- Assuming a second image exists for hover effect, otherwise remove or adapt --}}
                                                            @if (!empty($trendingProduct->gallery_image_paths) && count($trendingProduct->gallery_image_paths) > 0)
                                                                <img src="{{ Storage::url($trendingProduct->gallery_image_paths[0]) }}" class="img-fluid img2 mobile-img2" alt="{{ $trendingProduct->name }}">
                                                            @endif
                                                        </a>
                                                        <div class="product-action">
                                                            <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                <span class="tooltip-text">Vista rápida</span>
                                                                <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                            </a>
                                                            <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                <span class="tooltip-text">Añadir al carrito</span>
                                                                <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                            </a>
                                                            <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                <span class="tooltip-text">Lista de deseos</span>
                                                                <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        {{-- Assuming product_sub_title is a field or logic --}}
                                                        {{-- <div class="product-sub-title">
                                                            <span>Dispositivo inalámbrico</span>
                                                        </div> --}}
                                                        <div class="product-title">
                                                            <h6><a href="{{ route('product.show', ['slug' => $trendingProduct->slug]) }}">{{ $trendingProduct->name }}</a></h6>
                                                        </div>
                                                        <div class="product-price">
                                                            <div class="pro-price-box">
                                                                @if ($trendingProduct->sale_price && $trendingProduct->sale_price < $trendingProduct->price)
                                                                    <span class="new-price">${{ number_format($trendingProduct->sale_price, 2) }}</span>
                                                                    <span class="old-price">${{ number_format($trendingProduct->price, 2) }}</span>
                                                                @else
                                                                    <span class="new-price">${{ number_format($trendingProduct->price, 2) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="product-description">
                                                            <p>{{ $trendingProduct->short_description }}</p>
                                                        </div>
                                                        <div class="product-action">
                                                            <a href="#quickview" class="quickview" data-bs-toggle="modal" data-bs-target="#quickview">
                                                                <span class="tooltip-text">Vista rápida</span>
                                                                <span class="pro-action-icon"><i class="feather-eye"></i></span>
                                                            </a>
                                                            <a href="#add-to-cart" class="add-to-cart" data-bs-toggle="modal" data-bs-target="#add-to-cart">
                                                                <span class="tooltip-text">Añadir al carrito</span>
                                                                <span class="pro-action-icon"><i class="feather-shopping-bag"></i></span>
                                                            </a>
                                                            <a href="{{ route('wishlist.index') }}" class="wishlist">
                                                                <span class="tooltip-text">Lista de deseos</span>
                                                                <span class="pro-action-icon"><i class="feather-heart"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="pro-label-retting">
                                                        <div class="product-ratting">
                                                            <span class="pro-ratting">
                                                                {{-- Assuming rating is available, otherwise remove or make dynamic --}}
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                                <i class="fa-solid fa-star"></i>
                                                            </span>
                                                        </div>
                                                        @if ($trendingProduct->sale_price && $trendingProduct->sale_price < $trendingProduct->price)
                                                            @php
                                                                $discountPercentage = (($trendingProduct->price - $trendingProduct->sale_price) / $trendingProduct->price) * 100;
                                                            @endphp
                                                            <div class="product-label pro-new-sale">
                                                                <span class="product-label-title">Oferta<span>{{ round($discountPercentage) }}%</span></span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="collection-button">
                                        <a href="{{ route('collection.index') }}" class="btn btn-style2" data-animate="animate__fadeInUp">Ver todos los artículos</a>
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
        <!-- product-tranding end -->
    </main>
    <!-- main section end-->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Star rating functionality for review form
            const ratingInputContainer = document.querySelector('.rating-input');
            if (ratingInputContainer) {
                const stars = ratingInputContainer.querySelectorAll('label[data-value]');
                const selectedRatingInput = document.getElementById('selected-rating'); // This is no longer used for setting rating, but for getting old value

                stars.forEach(starLabel => {
                    starLabel.addEventListener('click', function() {
                        const value = parseInt(this.getAttribute('data-value'));
                        // The radio button itself now handles the name="rating"
                        // selectedRatingInput.value = value; // No longer needed for this approach

                        // Visually update stars
                        stars.forEach(s => {
                            const sValue = parseInt(s.getAttribute('data-value'));
                            if (sValue <= value) {
                                s.querySelector('i').classList.remove('far');
                                s.querySelector('i').classList.add('fas');
                            } else {
                                s.querySelector('i').classList.remove('fas');
                                s.querySelector('i').classList.add('far');
                            }
                        });
                    });
                });

                // Set initial state based on old('rating') if available
                const initialRating = document.querySelector('input[name="rating"]:checked');
                if (initialRating) {
                    const value = parseInt(initialRating.value);
                    stars.forEach(s => {
                        const sValue = parseInt(s.getAttribute('data-value'));
                        if (sValue <= value) {
                            s.querySelector('i').classList.remove('far');
                            s.querySelector('i').classList.add('fas');
                        } else {
                            s.querySelector('i').classList.remove('fas');
                            s.querySelector('i').classList.add('far');
                        }
                    });
                } else {
                    // Default to no stars filled if no old rating and no selection
                    stars.forEach(s => {
                        s.querySelector('i').classList.remove('fas');
                        s.querySelector('i').classList.add('far');
                    });
                }
            }

            // Show review form if there are validation errors after submission
            @if ($errors->any() && (session('form_type') === 'review_form'))
                const reviewCollapse = new bootstrap.Collapse(document.getElementById('add-review'), {
                    toggle: false
                });
                reviewCollapse.show();
                 document.getElementById('collapse-reviews').classList.add('show');
            @endif
        });
    </script>
</x-app-layout>