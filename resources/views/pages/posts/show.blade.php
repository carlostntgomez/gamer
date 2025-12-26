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
                                    <a class="breadcrumb-link" href="/">Inicio</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <a class="breadcrumb-link" href="{{ route('posts.index') }}">Blog</a>
                                </li>
                                <li class="breadcrumb-li">
                                    <span class="breadcrumb-text">{{ $post->title }}</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- article-area start -->
        <section class="article-area section-pt">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="blog-article-wrapper left-side">
                            <div class="blog-article-wrap blog-sidebar">
                                <!-- blog sidebar start -->
                                <div class="blog-sidebar-wrap">
                                    <!-- blog-sidebar search start -->
                                    <div class="blog-post-sidebar blog-search">
                                        <h6 class="blog-sidebar-title" data-animate="animate__fadeInUp">Buscar</h6>
                                        <div class="search-post" data-animate="animate__fadeInUp">
                                            <form action="{{ route('posts.search') }}" method="get">
                                                <input type="search" name="q" class="input-text" placeholder="Buscar en el blog" required autocomplete="off">
                                                <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- blog-sidebar search end -->
                                    <!-- blog-sidebar recent-post start -->
                                    <div class="blog-post-sidebar blog-recent-post">
                                        <h6 class="blog-sidebar-title" data-animate="animate__fadeInUp">Posts recientes</h6>
                                        @foreach($recentPosts as $recentPost)
                                        <div class="sidbar-inner sidbar-inner-wrap">
                                            <div class="post-image">
                                                <a href="{{ route('posts.show', $recentPost) }}" class="banner-img">
                                                    <img src="{{ Storage::url($recentPost->image_path) }}" class="img-fluid" alt="{{ $recentPost->title }}">
                                                </a>
                                            </div>
                                            <div class="recent-blog-content">
                                                <h6 data-animate="animate__fadeInUp">
                                                <a href="{{ route('posts.show', $recentPost) }}">{{ $recentPost->title }}</a>
                                                </h6>
                                                <span data-animate="animate__fadeInUp">{{ $recentPost->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- blog-sidebar recent-post end -->
                                </div>
                                <!-- blog sidebar end -->
                            </div>
                            <div class="blog-article-wrap blog-article">
                                <!-- blog single-post start -->
                                <div class="article-blog-post">
                                    <!-- blog img start -->
                                    <div class="blog-post-opt blog-post-img">
                                        <div class="blog-image">
                                            <a href="{{ route('posts.show', $post) }}" class="banner-img">
                                                <img src="{{ Storage::url($post->image_path) }}" class="img-fluid" alt="{{ $post->title }}">
                                            </a>
                                            <ul>
                                                <!-- blog-date start -->
                                                <li class="date-time">
                                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                </li>
                                                <!-- blog-date end -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- blog img start -->
                                    <!-- blog title start -->
                                    <div class="blog-post-opt blog-post-title">
                                        <div class="blog-revert">
                                            <h6 data-animate="animate__fadeInUp" class="post-title">{{ $post->title }}</h6>
                                            <!-- blog-info start -->
                                            <div class="post-info" data-animate="animate__fadeInUp">
                                                <span>Por {{ $post->user->name }}</span>
                                            </div>
                                            <!-- blog-info end -->
                                        </div>
                                    </div>
                                    <!-- blog title end -->
                                    <!-- blog content start -->
                                    <div class="blog-post-opt blog-post-content">
                                        <div class="blog-content">
                                            <div class="blog-wrap-desc">
                                                {!! $post->content !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- blog content end -->
                                </div>
                                <!-- blog single-post end -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- article-area end -->
            <!-- blog start -->
            <div class="our-blog section-ptb">
                <div class="blog-category">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="section-capture">
                                    <div class="section-title">
                                        <div class="section-cont-title">
                                            <h2 data-animate="animate__fadeInUp"><span>Posts Relacionados</span></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="blog-wrap">
                                    <div class="blog-slider owl-carousel owl-theme" id="blog-slider">
                                        @foreach($recentPosts as $recentPost)
                                        <div class="item" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ route('posts.show', $recentPost) }}" class="banner-img">
                                                        <img src="{{ Storage::url($recentPost->image_path) }}" class="img-fluid" alt="{{ $recentPost->title }}">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">{{ $recentPost->created_at->format('d') }}</span>
                                                            <span class="blog-month">{{ $recentPost->created_at->format('M') }}</span>
                                                            <span class="blog-year">{{ $recentPost->created_at->format('Y') }}</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2>{{ $recentPost->title }}</h2>
                                                    </div>
                                                    <p class="blog-title">{{ Str::limit(strip_tags($recentPost->excerpt), 80) }}</p>
                                                    <a href="{{ route('posts.show', $recentPost) }}" class="blog-btn btn-style2">Leer más</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- blog end -->
        </main>
        <!-- main section end-->
</x-app-layout>
