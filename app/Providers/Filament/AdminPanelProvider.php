<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => '#2563eb',
            ])
            ->navigationGroups([
                'E-commerce',
                'CRM',
                'Contenido',
                'Páginas Estáticas',
                'Configuración',
                'Home',
            ])
            ->resources([
                \App\Filament\Resources\ProductResource::class,
                \App\Filament\Resources\CategoryResource::class,
                \App\Filament\Resources\OrderResource::class,
                \App\Filament\Resources\DiscountResource::class,
                \App\Filament\Resources\ReviewResource::class,
                \App\Filament\Resources\UserResource::class,
                \App\Filament\Resources\AddressResource::class,
                \App\Filament\Resources\TicketResource::class,
                \App\Filament\Resources\WishlistResource::class,
                \App\Filament\Resources\PostResource::class,
                \App\Filament\Resources\TagResource::class,
                \App\Filament\Resources\BannerResource::class,
                \App\Filament\Resources\SettingResource::class,
                \App\Filament\Resources\BrandResource::class,
                \App\Filament\Resources\TestimonialResource::class,
                \App\Filament\Resources\TopCategoryResource::class,
                \App\Filament\Resources\NewArrivalResource::class,
                \App\Filament\Resources\OfferResource::class,
                \App\Filament\Resources\MainSliderResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
