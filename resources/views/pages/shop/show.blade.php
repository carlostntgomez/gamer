<x-layouts.app :product="$product">

    @php
        $approvedReviews = $product->reviews()->where('is_approved', true)->latest()->get();
        $reviewCount = $approvedReviews->count();
        $hasUserReviewed = auth()->check() && $product->reviews()->where('user_id', auth()->id())->exists();
        $discountPercentage = $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
    @endphp

    <!-- breadcrumb start -->
    <section class="breadcrumb-area">
        <div class="container">
            <div class="col">
                <div class="row">
                    <div class="breadcrumb-index">
                        <ul class="breadcrumb-ul">
                            <li class="breadcrumb-li"><a class="breadcrumb-link" href="{{ route('home') }}">Inicio</a></li>
                            <li class="breadcrumb-li"><a class="breadcrumb-link" href="{{ route('shop.index') }}">Tienda</a></li>
                            <li class="breadcrumb-li"><span class="breadcrumb-text">{{ $product->name }}</span></li>
                        </ul>
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
                             <div class="product-detail-img product-detail-img-left">
                                <div class="product-img-top">
                                    <button class="full-view"><i class="bi bi-arrows-fullscreen"></i></button>
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
                                <div class="pro-slider">
                                    <div class="style4-slider-small pro-detail-slider">
                                        <div class="slick-slide"><a href="javascript:void(0)" class="product-single--thumbnail"><img src="{{ Storage::url($product->main_image_path) }}" class="img-fluid" alt="{{ $product->name }}"></a></div>
                                        @foreach ($product->gallery_image_paths as $image)
                                            <div class="slick-slide"><a href="javascript:void(0)" class="product-single--thumbnail"><img src="{{ Storage::url($image) }}" class="img-fluid" alt="{{ $product->name }}"></a></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Product slider end -->

                        <!-- product detail start -->
                        <div class="product-details-wrap product-details-lr product-details">
                            <div class="product-details-info">
                                <div class="pro-nprist">
                                    <div class="product-info">
                                        <div class="product-title"><h2>{{ $product->name }}</h2></div>
                                        @if($product->brand)
                                        <div class="product-brand mt-1">
                                            <span style="font-size: 14px;">Marca: <a href="{{ route('brands.show', $product->brand) }}" class="text-primary">{{ $product->brand->name }}</a></span>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="product-info">
                                        <div class="product-ratting">
                                            {!! $product->getStarRatingHtml() !!}
                                            <a href="#collapse-reviews" class="spr-badge-caption">
                                            @if ($reviewCount > 0)
                                                {{ $reviewCount }} {{ Str::plural('valoración', $reviewCount) }}
                                            @else
                                                Sin valoraciones
                                            @endif
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="pro-prlb pro-sale">
                                            <div class="price-box">
                                                <span class="new-price">${{ number_format($product->sale_price ?? $product->price, 2) }}</span>
                                                @if ($product->sale_price)
                                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                                    <span class="percent-count">{{ $discountPercentage }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <div class="product-inventory">
                                            @if ($product->stock_quantity > 0)
                                                <div class="stock-inventory stock-more {{ $product->stock_quantity <= 20 ? '' : 'collapse' }}">
                                                    <p class="text-success">
                                                        ¡Date prisa! Solo quedan
                                                        <span class="available-stock bg-success">{{ $product->stock_quantity }}</span>
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
                                                    <p class="text-danger">Agotado</p>
                                                </div>
                                                <div class="product-variant">
                                                    <h6>Disponibilidad:</h6>
                                                    <span class="stock-qty out-stock text-danger">
                                                        <span>Fuera de stock</span>
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <p>{{ $product->short_description }}</p>
                                    </div>
                                    <div class="product-info">
                                        <form method="post" class="cart">
                                            @csrf
                                            <div class="pro-detail-button">
                                                <div class="product-quantity-button">
                                                    <div class="product-quantity-action">
                                                        <h6>Cantidad:</h6>
                                                        <div class="product-quantity">
                                                            <div class="cart-plus-minus">
                                                                <button type="button" class="dec qtybutton minus"><i class="feather-minus"></i></button>
                                                                <input type="text" name="quantity" value="1">
                                                                <button type="button" class="inc qtybutton plus"><i class="feather-plus"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn add-to-cart ajax-spin-cart add-to-cart-ajax" data-product-id="{{ $product->id }}">
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
                                        <div class="form-group">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#deliver-modal">Envío y devoluciones</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#que-modal">Haz una pregunta</a>
                                        </div>
                                    </div>
                                     <div class="product-info">
                                        <div class="product-sku">
                                            <h6>SKU:</h6>
                                            <span class="variant-sku">{{ $product->sku }}</span>
                                        </div>
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
                                            <div class="product-description">{!! $product->long_description !!}</div>
                                        </div>
                                    </div>
                                    <div class="tab">
                                        <a href="#collapse-specs" class="tab-title collapsed" data-bs-toggle="collapse">
                                            <h6 class="tab-name">Especificaciones</h6>
                                            <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                        </a>
                                        <div class="collapse" id="collapse-specs" data-bs-parent="#collapse-tab">
                                            <div class="product-additional-info">
                                                <table>
                                                    <tbody>
                                                        @if(is_array($product->specifications))
                                                            @foreach($product->specifications as $spec)
                                                                <tr class="product-info">
                                                                    <th>{{ $spec['key'] }}</th>
                                                                    <td>{{ $spec['value'] }}</td>
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
                                            <h6 class="tab-name">Valoraciones ({{ $reviewCount }})</h6>
                                            <span class="tab-icon"><i class="bi bi-plus"></i></span>
                                        </a>
                                        <div class="collapse" id="collapse-reviews" data-bs-parent="#collapse-tab">
                                            <div id="product-reviews">
                                                <div class="spr-container">
                                                    <div class="spr-content">
                                                        <h2 class="spr-header-title">Opiniones de clientes</h2>
                                                        @if(session('success'))
                                                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                                                        @endif
                                                        @if(session('error'))
                                                            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                                        @endif
                                                        <div class="spr-reviews">
                                                            @forelse($approvedReviews as $review)
                                                                <div class="spr-review">
                                                                    <div class="spr-review-header">
                                                                        <h3 class="spr-review-header-title">{{ $review->title }}</h3>
                                                                        <span class="spr-review-header-byline"><strong>{{ $review->user?->name ?? 'Usuario Anónimo' }}</strong> el <strong>{{ $review->created_at->format('d M. Y') }}</strong></span>
                                                                    </div>
                                                                    <div class="spr-review-content">
                                                                        <div class="product-ratting mb-2">{!! $review->getStarRatingHtml() !!}</div>
                                                                        <p class="spr-review-content-body">{{ $review->comment }}</p>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                {{-- This part is left empty as the summary will now handle the 'no reviews' case --}}
                                                            @endforelse
                                                        </div>

                                                        <div class="spr-summary-bottom-wrapper mt-5 text-center">
                                                            <div class="spr-summary rte">
                                                                @if ($reviewCount > 0)
                                                                    <div class="mb-3">
                                                                        <span class="spr-summary-starrating">
                                                                            {!! $product->getStarRatingHtml() !!}
                                                                        </span>
                                                                        <span class="spr-summary-caption">
                                                                            Basado en {{ $reviewCount }} {{ Str::plural('reseña', $reviewCount) }}
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <p class="spr-summary-caption">Aún no hay reseñas</p>
                                                                @endif
                                                                
                                                                @auth
                                                                    @if(!$hasUserReviewed)
                                                                    <span class="spr-summary-actions">
                                                                        <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#add-review">
                                                                            @if($reviewCount > 0) Escribir una reseña @else Sé el primero en escribir una reseña @endif
                                                                        </button>
                                                                    </span>
                                                                    @endif
                                                                @else
                                                                    <div class="spr-summary-actions">
                                                                        {{-- <p>Para escribir una reseña, por favor <a href="{{ route('login') }}">inicia sesión</a>.</p> --}}
                                                                    </div>
                                                                @endauth
                                                            </div>
                                                        </div>

                                                        @auth
                                                            @if(!$hasUserReviewed)
                                                                <div class="spr-form collapse" id="add-review">
                                                                    <form method="post" action="{{ route('reviews.store', $product) }}" class="new-review-form">
                                                                        @csrf
                                                                        <h3 class="spr-form-title mt-4">Escribe una reseña</h3>
                                                                        <fieldset class="spr-form-review">
                                                                            <div class="spr-form-review-rating">
                                                                                <label class="spr-form-label">Puntuación</label>
                                                                                <div class="rating-input-wrapper">
                                                                                     <select name="rating" class="spr-form-input spr-form-input-select" required>
                                                                                        <option value="">Selecciona una puntuación</option>
                                                                                        <option value="5">5 Estrellas</option>
                                                                                        <option value="4">4 Estrellas</option>
                                                                                        <option value="3">3 Estrellas</option>
                                                                                        <option value="2">2 Estrellas</option>
                                                                                        <option value="1">1 Estrella</option>
                                                                                    </select>
                                                                                    @error('rating') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                                                                </div>
                                                                            </div>
                                                                            <div class="spr-form-review-title">
                                                                                <label class="spr-form-label" for="review-title">Título de la reseña</label>
                                                                                <input class="spr-form-input spr-form-input-text" id="review-title" type="text" name="title" value="{{ old('title') }}" placeholder="Dale un título a tu reseña" required>
                                                                                 @error('title') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                                                            </div>
                                                                            <div class="spr-form-review-body">
                                                                                <label class="spr-form-label" for="review-body">Cuerpo de la reseña</label>
                                                                                <div class="spr-form-input">
                                                                                    <textarea id="review-body" class="spr-form-input spr-form-input-textarea" name="comment" rows="10" placeholder="Escribe tus comentarios aquí" required>{{ old('comment') }}</textarea>
                                                                                    @error('comment') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                                                                </div>
                                                                            </div>
                                                                        </fieldset>
                                                                        <fieldset class="spr-form-actions">
                                                                             <button type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary">Enviar Reseña</button>
                                                                        </fieldset>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="alert alert-info mt-4">Ya has valorado este producto. ¡Gracias por tu opinión!</div>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($product->video_url)
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="video section-pt">
                        <div class="video-wrapper">
                            <iframe src="{{ $product->getYoutubeEmbedUrl() }}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </section>
    <!-- pro-detail-page-tab end -->

    <!-- additional-product-section start -->
    @if (isset($additional_products) && $additional_products->count() > 0)
    <section class="additional-product bg-color section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <span class="sub-title" data-animate="animate__fadeInUp">Explora más</span>
                            <h2><span data-animate="animate__fadeInUp">Productos Adicionales</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @foreach ($additional_products as $additional_product)
                        <div class="col-lg-4 col-md-6 col-12">
                            <x-product-card :product="$additional_product" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- additional-product-section end -->

    <!-- related-product-tranding start -->
    @if (isset($related_products) && $related_products->count() > 0)
    <section class="Trending-product bg-color section-ptb">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <span class="sub-title" data-animate="animate__fadeInUp">No te lo pierdas</span>
                            <h2><span data-animate="animate__fadeInUp">Productos Relacionados</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row gy-4">
                    @foreach ($related_products as $related)
                        <div class="col-lg-4 col-md-6 col-12">
                            <x-product-card :product="$related" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- related-product-tranding end -->

</x-layouts.app>
