<!-- mobile menu start -->
<div class="mobile-menu" id="mobile-menu">
    <div class="mobile-contents">
        <div class="menu-close">
            <button class="menu-close-btn">
                <span class="menu-close-icon"><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>
            </button>
        </div>
        <div class="mobilemenu-content">
            <div class="main-wrap">
                <ul class="main-menu">
                    <li class="menu-link">
                        <a href="{{ route('home') }}" class="link-title">
                            <span class="sp-link-title">Inicio</span>
                        </a>
                    </li>
                    <li class="menu-link">
                        <a href="{{ route('shop.index') }}" class="link-title">
                            <span class="sp-link-title">Tienda</span>
                        </a>
                    </li>
                    <x-mega-menu :categories="$categories" :isMobile="true" />
                    <li class="menu-link">
                        <a href="{{ route('posts.index') }}" class="link-title">
                            <span class="sp-link-title">Blog</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- mobile menu end -->