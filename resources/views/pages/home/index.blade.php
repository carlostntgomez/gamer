<x-layouts.app>
    <x-home.main-slider />
    <x-home.top-categories />
    <x-home.banners :banners="$banners" />
    <x-home.trending-products :featured-products="$featuredProducts" />
    <x-home.offers />
    <x-home.new-products :new-products="$newProducts" />
    <x-home.brand-logos :brands="$brands" />
</x-layouts.app>
