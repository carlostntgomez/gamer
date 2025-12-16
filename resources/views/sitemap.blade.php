<x-app-layout>
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
                                    <a class="breadcrumb-link" href="{{ route('home') }}">Home</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">Site map</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- sitemap start -->
        <section class="site-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="site-map-block">
                            <ul class="sit-map-ul">
                                <li class="site-map-li">
                                    <div class="site-main-title">
                                        <h2><a href="{{ route('home') }}" class="site-title" data-animate="animate__fadeInUp">Home</a></h2>
                                        <ul class="site-sub-link">
                                            <li class="site-link"><a href="{{ route('home') }}" data-animate="animate__fadeInUp">01 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.2') }}" data-animate="animate__fadeInUp">02 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.3') }}" data-animate="animate__fadeInUp">03 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.4') }}" data-animate="animate__fadeInUp">04 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.5') }}" data-animate="animate__fadeInUp">05 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.6') }}" data-animate="animate__fadeInUp">06 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.7') }}" data-animate="animate__fadeInUp">07 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.8') }}" data-animate="animate__fadeInUp">08 Demo</a></li>
                                            <li class="site-link"><a href="{{ route('home.variation.9') }}" data-animate="animate__fadeInUp">09 Demo</a></li>

                                        </ul>
                                    </div>
                                </li>
                                <li class="site-map-li" data-animate="animate__fadeInUp">
                                    <div class="site-main-title">
                                        <h2><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}" class="site-title" data-animate="animate__fadeInUp">Product</a></h2>
                                        <ul class="site-sub-link">
                                            <li class="site-title" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Shop page</a> </li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('collection.without') }}">01 Collection</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('collection.index') }}">02 Collection left</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('collection.right') }}">03 Collection right</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('collection.list') }}">04 Collection list</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('collection.list') }}">05 Collection list left</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('collection.list.right') }}">06 Collection list right</a></li>
                                        </ul>
                                        <ul class="site-sub-link">
                                            <li class="site-title" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">Product page</a> </li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">01 Product layout</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">02 Product tab</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">03 Product advance</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">04 Product accordion</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">05 Product center</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">06 Product sticky</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('product.show', ['slug' => 'PLACEHOLDER_SLUG']) }}">07 Product side</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="site-map-li">
                                    <div class="site-main-title">
                                        <h2><a href="{{ route('page.about_us') }}" class="site-title" data-animate="animate__fadeInUp">Collection</a></h2>
                                        <ul class="site-sub-link">
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.index') }}">Wireless earbuds</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.index') }}">Portable speaker</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.index') }}">Air conditioner</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.index') }}">Ev charging plug</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="site-map-li">
                                    <div class="site-main-title">
                                        <h2><a href="{{ route('blog.grid.index') }}" class="site-title" data-animate="animate__fadeInUp">Blogs</a></h2>
                                        <ul class="site-sub-link">
                                            <li class="site-title" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.index') }}">Blog page</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.without') }}">01 Blog grid</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.index') }}">02 Blog grid left</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.grid.right') }}">03 Blog grid right</a> </li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.article.without') }}">04 Article post</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.article.show') }}">05 Article post left</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('blog.article.right') }}">06 Article post right</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="site-map-li" data-animate="animate__fadeInUp">
                                    <div class="site-main-title">
                                        <h2><a href="{{ route('page.about_us') }}" class="site-title" data-animate="animate__fadeInUp">Pages</a></h2>
                                        <ul class="site-sub-link">
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.about_us') }}">About us</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.faq') }}">Faq's</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.contact_us') }}">Contact</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.payment_policy') }}">payment policy</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.privacy_policy') }}">privacy policy</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.return_policy') }}">Return policy</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.terms_condition') }}">Terms &amp; conditions</a></li>
                                            <li class="site-link" data-animate="animate__fadeInUp"><a href="{{ route('page.sitemap') }}">Sitemap</a></li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- sitemap end -->
    </main>
</x-app-layout>