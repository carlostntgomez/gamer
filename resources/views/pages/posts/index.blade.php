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
                                    <span class="breadcrumb-text">Blog</span>
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
        <section class="article-area section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="blog-grid-wrapper left-side">
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
                                                    <img src="{{ $recentPost->main_image_url }}" class="img-fluid" alt="{{ $recentPost->title }}">
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

                                    <!-- blog-sidebar tag start -->
                                    <div class="blog-post-sidebar blog-tags" data-animate="animate__fadeInUp">
                                        <h6 class="blog-sidebar-title">Etiquetas</h6>
                                        <div class="sidebartag">
                                            <ul class="sidebar-tag">
                                                @foreach($allTags as $tag)
                                                <li data-animate="animate__fadeInUp"><a href="#">{{$tag->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- blog-sidebar tag end -->
                                </div>
                                <!-- blog sidebar end -->
                            </div>
                            <div class="blog-grid-wrap blog-article">
                                <div class="blog-grid-view">
                                    <ul class="blog-area-wrap">
                                        @foreach($posts as $post)
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ route('posts.show', $post) }}" class="banner-img">
                                                        <img src="{{ $post->main_image_url }}" class="img-fluid" alt="{{ $post->title }}">
                                                        <span class="blog-icon">
                                                            <i class="fas fa-paperclip"></i>
                                                        </span>
                                                        <span class="blog-date-time">
                                                            <span class="blog-date">{{ $post->created_at->format('d') }}</span>
                                                            <span class="blog-month">{{ $post->created_at->format('M') }}</span>
                                                            <span class="blog-year">{{ $post->created_at->format('Y') }}</span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="blog-content">
                                                    <div class="blog-tag">
                                                        <h2 class="wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{ $post->title }}</h2>
                                                    </div>
                                                    <p class="blog-title wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">{{ $post->excerpt }}</p>
                                                    <a href="{{ route('posts.show', $post) }}" class="blog-btn btn-style2 wow animate__animated animate__fadeInUp" data-wow-delay="0.2s">Leer más</a>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <div class="paginatoin-area">
                                       <div class="pagination-page-box" data-animate="animate__fadeInUp">
                                             {{ $posts->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- article-area end -->
    </main>
    <!-- main section end-->
</x-app-layout>
