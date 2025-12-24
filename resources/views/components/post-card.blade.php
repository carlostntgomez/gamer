@props(['post'])

<div class="bg-white dark:bg-base-100 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 ease-in-out flex flex-col">
    <a href="{{ route('blog.show', $post->slug) }}">
        @if($post->image_path)
            <img class="w-full h-48 object-cover" src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}">
        @else
            <div class="w-full h-48 bg-base-200 dark:bg-base-300 flex items-center justify-center">
                <svg class="w-12 h-12 text-base-content text-opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l-1.586-1.586a2 2 0 00-2.828 0L6 18"></path></svg>
            </div>
        @endif
    </a>
    <div class="p-6 flex flex-col flex-grow">
        @if($post->published_at)
        <p class="text-sm text-neutral-content mb-2">{{ $post->published_at->isoFormat('D [de] MMMM, YYYY') }}</p>
        @endif
        <h3 class="text-xl font-bold text-base-content mb-2 flex-grow">
            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary transition-colors">
                {{ $post->title }}
            </a>
        </h3>
        <p class="text-neutral-content mb-4">
            {{ Str::limit($post->excerpt, 100) }}
        </p>
        <div class="mt-auto">
            <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary btn-sm">
                Leer más
            </a>
        </div>
    </div>
</div>
