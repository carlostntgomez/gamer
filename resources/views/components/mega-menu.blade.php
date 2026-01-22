@props(['categories', 'isMobile' => false])

<li class="menu-link">
    {{-- The main "Explorar" link --}}
    @if ($isMobile)
        <a class="link-title" data-bs-toggle="collapse" href="#collapse-categories-mobile" role="button"
            aria-expanded="false" aria-controls="collapse-categories-mobile">
            <span class="sp-link-title">Explorar</span>
            <span class="menu-arrow"><i class="fa fa-angle-down"></i></span>
        </a>
    @else
        <a href="{{ route('shop.index') }}" class="link-title">
            <span class="sp-link-title">Explorar</span>
            <span class="menu-arrow"><i class="fa fa-angle-down"></i></span>
        </a>
    @endif

    {{-- The dropdown container --}}
    <div class="menu-dropdown {{ $isMobile ? 'menu-sub' : 'menu-mega' }} collapse"
        id="{{ $isMobile ? 'collapse-categories-mobile' : 'collapse-categories' }}">
        <ul class="ul {{ $isMobile ? '' : 'container p-0' }}">
            @foreach ($categories as $category)
                <li class="{{ $isMobile ? 'menusub-li' : 'menumega-li' }}">

                    {{-- The category link --}}
                    @if ($isMobile && $category->children->isNotEmpty())
                        <a class="{{ $isMobile ? 'menusub-title' : 'menumega-title' }}" data-bs-toggle="collapse"
                            href="#collapse-subcategory-{{ $category->id }}" role="button" aria-expanded="false"
                            aria-controls="collapse-subcategory-{{ $category->id }}">
                            <span class="sp-link-title">{{ $category->name }}</span>
                            <span class="menu-arrow"><i class="fa-solid fa-angle-down"></i></span>
                        </a>
                    @else
                        <a href="{{ route('categories.show', $category) }}"
                            class="{{ $isMobile ? 'menusub-title' : 'menumega-title' }}">
                            <span class="sp-link-title">{{ $category->name }}</span>
                        </a>
                    @endif

                    {{-- The sub-category dropdown --}}
                    @if ($category->children->isNotEmpty())
                        <div class="collapse {{ $isMobile ? 'menusup-dropdown' : 'menumegasup-dropdown' }}"
                            id="{{ $isMobile ? 'collapse-subcategory-' . $category->id : '' }}">
                            <ul class="{{ $isMobile ? 'menusup-ul' : 'menumegasup-ul' }}">
                                @foreach ($category->children as $child)
                                    <li class="{{ $isMobile ? 'menusup-li' : 'menumegasup-li' }}">
                                        <a href="{{ route('categories.show', $child) }}"
                                            class="{{ $isMobile ? 'menusup-title' : 'menumegasup-title' }}">
                                            <span class="sp-link-title">{{ $child->name }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</li>
