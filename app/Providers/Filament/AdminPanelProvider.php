<?php

namespace App\Providers\Filament;

use App\Filament\Pages\GeminiApiSettings;
use App\Filament\Resources\AddressResource;
use App\Filament\Resources\AuthorResource;
use App\Filament\Resources\BannerResource;
use App\Filament\Resources\BrandResource;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\MainSliderResource;
use App\Filament\Resources\OfferResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ReviewResource;
use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ShippingZoneResource;
use App\Filament\Resources\TagResource;
use App\Filament\Resources\TestimonialResource;
use App\Filament\Resources\TopCategoryResource;
use App\Filament\Resources\UserResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
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
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
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
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->items([
                    NavigationItem::make('Inicio')
                        ->icon('heroicon-o-home')
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard'))
                        ->url(fn (): string => Pages\Dashboard::getUrl()),
                ])->groups([
                    NavigationGroup::make('Tienda')
                        ->items([
                            NavigationItem::make('Pedidos')->icon('heroicon-o-inbox-stack')->url(OrderResource::getUrl('index')),
                            NavigationItem::make('Productos')->icon('heroicon-o-shopping-bag')->url(ProductResource::getUrl('index')),
                            NavigationItem::make('Categorías')->icon('heroicon-o-tag')->url(CategoryResource::getUrl('index')),
                            NavigationItem::make('Marcas')->icon('heroicon-o-building-storefront')->url(BrandResource::getUrl('index')),
                            NavigationItem::make('Zonas de Envío')->icon('heroicon-o-truck')->url(ShippingZoneResource::getUrl('index')),
                             NavigationItem::make('Reseñas')->icon('heroicon-o-star')->url(ReviewResource::getUrl('index')),
                        ]),
                    NavigationGroup::make('Página Principal')
                        ->items([
                            NavigationItem::make('Sliders Principales')->icon('heroicon-o-presentation-chart-line')->url(MainSliderResource::getUrl('index')),
                            NavigationItem::make('Banners')->icon('heroicon-o-photo')->url(BannerResource::getUrl()),
                            NavigationItem::make('Categorías Destacadas')->icon('heroicon-o-arrow-up-on-square')->url(TopCategoryResource::getUrl('index')),
                            NavigationItem::make('Ofertas')->icon('heroicon-o-gift')->url(OfferResource::getUrl('index')),
                        ]),
                    NavigationGroup::make('Contenido')
                        ->items([
                            NavigationItem::make('Publicaciones (Blog)')->icon('heroicon-o-document-text')->url(PostResource::getUrl('index')),
                            NavigationItem::make('Autores')->icon('heroicon-o-user-circle')->url(AuthorResource::getUrl('index')),
                            NavigationItem::make('Etiquetas')->icon('heroicon-o-hashtag')->url(TagResource::getUrl('index')),
                            NavigationItem::make('Testimonios')->icon('heroicon-o-chat-bubble-left-right')->url(TestimonialResource::getUrl('index')),
                        ]),
                    NavigationGroup::make('Clientes')
                        ->items([
                            NavigationItem::make('Usuarios')->icon('heroicon-o-user-group')->url(UserResource::getUrl('index')),
                            NavigationItem::make('Direcciones')->icon('heroicon-o-map-pin')->url(AddressResource::getUrl('index')),
                        ]),
                    NavigationGroup::make('Ajustes')
                        ->items([
                            NavigationItem::make('Configuración General')->icon('heroicon-o-cog-6-tooth')->url(SettingResource::getUrl('index')),
                            NavigationItem::make('API de Gemini')->icon('heroicon-o-key')->url(GeminiApiSettings::getUrl()),
                        ]),
                ]);
            });
    }
}
