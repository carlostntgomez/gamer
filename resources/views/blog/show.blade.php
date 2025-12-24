<x-app-layout :title="$post->seo_title ?? $post->title" :description="$post->seo_description ?? $post->excerpt">

    <!-- Breadcrumb -->
    <div class="container mx-auto py-8 px-4 md:px-0">
        <div class="text-sm breadcrumbs">
            <ul>
                <li><a href="{{ route('home') }}">Inicio</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li>{{ Str::limit($post->title, 40) }}</li>
            </ul>
        </div>
    </div>

    <!-- Article Area -->
    <section class="pb-12">
        <div class="container mx-auto px-4 md:px-0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Post Content -->
                <div class="lg:col-span-2 bg-white dark:bg-base-200 rounded-lg shadow-lg p-6">
                    <article class="blog-article">
                        <!-- Blog Image -->
                        @if($post->image_path)
                            <div class="mb-6 rounded-lg overflow-hidden">
                                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
                            </div>
                        @endif

                        <!-- Blog Title -->
                        <header>
                            <h1 class="text-3xl md:text-4xl font-extrabold text-base-content mb-4">{{ $post->title }}</h1>
                        </header>
                        
                        <!-- Blog Content -->
                        <div class="prose dark:prose-invert max-w-none text-base-content">
                            {!! $post->content !!}
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        <!-- Author Info -->
                        <div class="bg-white dark:bg-base-200 rounded-lg shadow p-6 text-center">
                            <img class="mx-auto h-20 w-20 rounded-full" src="{{ $post->user->getAvatarUrl() }}" alt="{{ $post->user->name }}">
                            <h4 class="text-xl font-semibold mt-4 text-base-content">{{ $post->user->name }}</h4>
                            <p class="text-sm text-neutral-content">Autor</p>
                            @if($post->published_at)
                            <p class="text-xs text-neutral-content mt-2">Publicado el {{ $post->published_at->isoFormat('D [de] MMMM, YYYY') }}</p>
                            @endif
                        </div>

                        <!-- Tags -->
                        @if($post->tags->isNotEmpty())
                            <div class="bg-white dark:bg-base-200 rounded-lg shadow p-6">
                                <h3 class="text-xl font-semibold mb-4 text-base-content">Etiquetas</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($post->tags as $tag)
                                        <a href="#" class="badge badge-primary hover:badge-secondary">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Recent Posts -->
                        @if($recentPosts->isNotEmpty())
                        <div class="bg-white dark:bg-base-200 rounded-lg shadow p-6">
                            <h3 class="text-xl font-semibold mb-4 text-base-content">Publicaciones Recientes</h3>
                            <ul class="space-y-4">
                                @foreach($recentPosts as $recentPost)
                                    <li>
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('blog.show', $recentPost->slug) }}">
                                                    <img class="h-16 w-16 rounded-md object-cover" src="{{ $recentPost->image_path ? Storage::url($recentPost->image_path) : url('/images/placeholder.png') }}" alt="{{ $recentPost->title }}">
                                                </a>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <a href="{{ route('blog.show', $recentPost->slug) }}" class="text-base-content font-semibold hover:text-primary transition-colors">
                                                    {{ $recentPost->title }}
                                                </a>
                                                @if($recentPost->published_at)
                                                <p class="text-sm text-neutral-content truncate">{{ $recentPost->published_at->diffForHumans() }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
        <div class="py-12 bg-base-200 dark:bg-base-300">
            <div class="container mx-auto px-4 md:px-0">
                <h2 class="text-3xl font-bold text-center text-base-content mb-8">También te podría interesar</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $relatedPost)
                        <x-post-card :post="$relatedPost" />
                    @endforeach
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
