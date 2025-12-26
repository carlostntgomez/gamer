<x-app-layout>
    <!-- main section start-->
    <main>
        <!-- breadcrumb start -->
        <section class="breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
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
                                    <span class="breadcrumb-text">Búsqueda: {{ request('q') }}</span>
                                </li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->
        <!-- search-blog start -->
        <section class="search-page section-ptb">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-capture">
                            <div class="section-title">
                                <h2 data-animate="animate__fadeInUp"><span>Tu búsqueda de "{{ request('q') }}" arrojó los siguientes resultados:</span></h2>
                            </div>
                        </div>
                        <div class="saerch-input" data-animate="animate__fadeInUp">
                            <form action="{{ route('posts.search') }}" method="get">
                                <input type="text" name="q" placeholder="Buscar en nuestra tienda" value="{{ request('q') }}">
                                <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <!-- blog-content start -->
                        <div class="blog-grid-wrapper without-wrap">
                            <div class="blog-grid-wrap blog-article">
                                <div class="blog-grid-view">
                                    <ul class="blog-area-wrap">
                                        @forelse($posts as $post)
                                        <li class="blog-slider" data-animate="animate__fadeInUp">
                                            <div class="blog-post">
                                                <div class="blog-img">
                                                    <a href="{{ route('posts.show', $post) }}" class="banner-img">
                                                        <img src="{{ Storage::url($post->image_path) }}" class="img-fluid" alt="{{ $post->title }}">
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
                                                        <h2>{{ $post->title }}</h2>
                                                    </div>
                                                    <p class="blog-title">{{ $post->excerpt }}</p>
                                                    <a href="{{ route('posts.show', $post) }}" class="blog-btn">Leer más</a>
                                                </div>
                                            </div>
                                        </li>
                                        @empty
                                            <li class="blog-slider" data-animate="animate__fadeInUp">
                                                <p>No se encontraron resultados para tu búsqueda.</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                    <div class="paginatoin-area">
                                        {{ $posts->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- blog-content end -->
                    </div>
                </div>
            </div>
        </section>
        <!-- search-blog end -->
    </main>
    <!-- main section end-->
</x-app-layout>
