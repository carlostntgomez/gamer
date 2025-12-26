@if ($paginator->hasPages())
    <div class="paginatoin-area">
        <ul class="pagination-page-box" data-animate="animate__fadeInUp">
            {{-- Previous Page Link --}}
            @if (!$paginator->onFirstPage())
                <li class="page-prev">
                    <a href="{{ $paginator->previousPageUrl() }}" class="theme-glink" rel="prev">
                        <i class="fa-solid fa-angle-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="number disabled">
                        <a href="javascript:void(0)" class="gradient-text">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="number active">
                                <a href="javascript:void(0)" class="theme-glink">{{ $page }}</a>
                            </li>
                        @else
                            <li class="number">
                                <a href="{{ $url }}" class="gradient-text">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-next">
                    <a href="{{ $paginator->nextPageUrl() }}" class="theme-glink" rel="next">
                        <i class="fa-solid fa-angle-right"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
