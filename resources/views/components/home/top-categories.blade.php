<section class="category-shop section-pt">
    <div class="shop-category">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="section-capture">
                        <div class="section-title">
                            <h2 data-animate="animate__fadeInUp"><span>Categorías Destacadas</span></h2>
                        </div>
                    </div>
                    <div class="category-wrap">
                        <div class="cat-slider swiper" id="cat-slider8">
                            <div class="swiper-wrapper">
                                @foreach($topCategories as $topCategory)
                                <div class="swiper-slide" data-animate="animate__fadeInUp">
                                    <div class="cat-info">
                                        <div class="cat-img">
                                            <a href="{{ route('categories.show', $topCategory->category->slug) }}">
                                                <img src="{{ asset('storage/' . $topCategory->category->image_path) }}" class="img-fluid" alt="{{ $topCategory->category->name }}">
                                                <span class="cat-title">{{ $topCategory->category->name }}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="swiper-buttons">
                            <div class="swiper-buttons-wrap">
                                <button class="swiper-prev swiper-prev-cat8"><span><i class="fa-solid fa-arrow-left"></i></span></button>
                                <button class="swiper-next swiper-next-cat8"><span><i class="fa-solid fa-arrow-right"></i></span></button>
                            </div>
                        </div>
                        <div class="swiper-dots" data-animate="animate__fadeInUp">
                            <div class="swiper-pagination swiper-pagination-cat8"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>