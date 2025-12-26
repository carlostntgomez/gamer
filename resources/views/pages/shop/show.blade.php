<x-layouts.app>

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
                                <a class="breadcrumb-link" href="{{ route('shop.index') }}">Tienda</a>
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
                                    <button class="full-view">
                                        <i class="bi bi-arrows-fullscreen"></i>
                                    </button>
                                    <!-- blog slick slider start -->
                                    <div class="style4-slider-big slick-slider">
                                        <div class="slick-slide">
                                            <a href="{{ Storage::url($product->main_image_path) }}" class="product-single">
                                                <figure class="zoom" onmousemove="zoom(event)" style="background-image: url('{{ Storage::url($product->main_image_path) }}');">
                                                    <img src="{{ Storage::url($product->main_image_path) }}" class="img-fluid" alt="{{ $product->name }}">
                                                </figure>
                                            </a>
                                        </div>
                                        @foreach ($product->gallery_image_paths as $image)
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
                                        <div class="slick-slide">
                                            <a href="javascript:void(0)" class="product-single--thumbnail">
                                                <img src="{{ Storage::url($product->main_image_path) }}" class="img-fluid" alt="{{ $product->name }}">
                                            </a>
                                        </div>
                                        @foreach ($product->gallery_image_paths as $image)
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
                        <!-- peoduct detail start -->
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
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </span>
                                            <span class="spr-badge-caption">Sin valoraciones</span>
                                        </div>
                                        <!-- product-rating end -->
                                    </div>
                                    <div class="product-info">
                                        <div class="pro-prlb pro-sale">
                                            <div class="price-box">
                                                <span class="new-price">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                                                @if ($product->sale_price)
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-inventory">
                                            <div class="stock-inventory {{ $product->stock_quantity > 0 ? 'stock-more' : 'stock-zero' }}">
                                                <p class="{{ $product->stock_quantity > 0 ? 'text-success' : 'text-danger' }}">
                                                    @if ($product->stock_quantity > 0)
                                                        ¡Date prisa! Solo quedan
                                                        <span class="available-stock bg-success">{{ $product->stock_quantity }}</span>
                                                        ¡productos en stock!
                                                    @else
                                                        Agotado
                                                        <span class="available-stock bg-danger">{{ $product->stock_quantity }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="product-variant">
                                                <h6>Disponibilidad:</h6>
                                                <span class="stock-qty {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-stock' }} text-success">
                                                    <span>
                                                        {{ $product->stock_quantity > 0 ? 'En stock' : 'Agotado' }}<i class="bi bi-check2"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <p>{{ $product->short_description }}</p>
                                    </div>
                                    <div class="product-info">
                                        <div class="pro-detail-action">
                                            <form method="get" class="cart">
                                                <div class="product-variant-option">
                                                    @if ($product->colors)
                                                        <div class="swatch-variant">
                                                            <div class="swatch clearfix Color">
                                                                <div class="header">
                                                                    <h6>
                                                                        <span>Color:</span>
                                                                        <span class="data-value">{{ $product->colors[0] }}</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="variant-wrap">
                                                                    <div class="variant-property">
                                                                        @foreach ($product->colors as $color)
                                                                            <div class="swatch-element color {{ $color }}">
                                                                                <input type="radio" name="option-0" value="{{ $color }}" @if ($loop->first) checked @endif>
                                                                                <label>{{ $color }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                                                <button class="dec qtybutton minus">
                                                                    <i class="feather-minus"></i>
                                                                </button>
                                                                <input type="text" name="quantity" value="1">
                                                                <button class="inc qtybutton plus">
                                                                    <i class="feather-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" onclick="location. href='cart-page.html'" class="btn add-to-cart ajax-spin-cart">
                                                        <span class="cart-title">Añadir al carrito</span>
                                                    </button>
                                                </div>
                                                <a href="cart-empty.html" class="btn btn-cart btn-theme">
                                                    <span>Comprar ahora</span>
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-actions">
                                            <!-- pro-deatail wishlist start -->
                                            <div class="pro-aff-che">
                                                <a href="wishlist-product.html" class="wishlist">
                                                    <span class="wishlist-icon action-wishlist tile-actions--btn wishlist-btn">
                                                        <span class="add-wishlist">
                                                            <i class="bi bi-heart"></i>
                                                        </span>
                                                    </span>
                                                    <span class="wishlist-text">Lista de deseos</span>
                                                </a>
                                            </div>
                                            <!-- pro-deatail wishlist end -->
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-sku">
                                            <h6>SKU:</h6>
                                            <span class="variant-sku">{{ $product->sku }}</span>
                                        </div>
                                    </div>
                                </div>
                                <section class="product-description-tab">
                                    <div class="product-tab" id="collapse-tab">
                                        <div class="tab">
                                            <a href="#collapse-description" class="tab-title" data-bs-toggle="collapse" aria-expanded="true">
                                                <h6 class="tab-name">Descripción</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse show" id="collapse-description" data-bs-parent="#collapse-tab">
                                                <div class="product-description">
                                                    {!! $product->long_description !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <a href="#collapse-specs" class="tab-title collapsed" data-bs-toggle="collapse">
                                                <h6 class="tab-name">Especificaciones Técnicas</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse" id="collapse-specs" data-bs-parent="#collapse-tab">
                                                <div class="product-additional-info">
                                                    <table>
                                                        <tbody>
                                                            <tr class="product-info">
                                                                <th>Marca</th>
                                                                <td><a href="javascript:void(0)">{{ $product->brand->name }}</a></td>
                                                            </tr>
                                                            <tr class="product-info">
                                                                <th>Tipo</th>
                                                                <td><a href="javascript:void(0)">{{ $product->type->getLabel() }}</a></td>
                                                            </tr>
                                                            <tr class="product-info">
                                                                <th>SKU</th>
                                                                <td>{{ $product->sku }}</td>
                                                            </tr>
                                                            @if(is_array($product->specifications))
                                                                @foreach($product->specifications as $specKey => $specValue)
                                                                    <tr class="product-info">
                                                                        <th>{{ $specKey }}</th>
                                                                        <td>{{ $specValue }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab">
                                            <a href="#collapse-reviews" class="tab-title collapsed" data-bs-toggle="collapse">
                                                <h6 class="tab-name">Valoraciones ({{ $product->reviews->count() }})</h6>
                                                <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                            </a>
                                            <div class="collapse" id="collapse-reviews" data-bs-parent="#collapse-tab">
                                                <div class="product-review-area">
                                                    @forelse($product->reviews as $review)
                                                        <div class="product-review-item">
                                                            <div class="product-review-info">
                                                                <h6 class="product-review-author">{{ $review->user->name }}</h6>
                                                                <div class="product-ratting">
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <i class="{{ $i < $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="product-review-content">
                                                                <p>{{ $review->comment }}</p>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>Aún no hay valoraciones para este producto. ¡Sé el primero en dejar una!</p>
                                                    @endforelse
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
        </div>
    </section>
    <!-- pro-detail-page-tab end -->

</x-layouts.app>
