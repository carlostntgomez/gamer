<?php

namespace App\Providers;

use App\Models\Author;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\MainSlider;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use App\Observers\AuthorObserver;
use App\Observers\BannerObserver;
use App\Observers\BrandObserver;
use App\Observers\CategoryObserver;
use App\Observers\MainSliderObserver;
use App\Observers\OfferObserver;
use App\Observers\OrderObserver;
use App\Observers\PostObserver;
use App\Observers\ProductObserver;
use App\Observers\TestimonialObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Product::class => [ProductObserver::class],
        MainSlider::class => [MainSliderObserver::class],
        Post::class => [PostObserver::class],
        Author::class => [AuthorObserver::class],
        Category::class => [CategoryObserver::class],
        Brand::class => [BrandObserver::class],
        Offer::class => [OfferObserver::class],
        Banner::class => [BannerObserver::class],
        Testimonial::class => [TestimonialObserver::class],
        User::class => [UserObserver::class],
        Order::class => [OrderObserver::class],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // --- Contenido de AppServiceProvider ---
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            $cart = session()->get('cart', []);
            $cartCount = count($cart);
            $view->with('cartCount', $cartCount);
            $view->with('categories', Category::whereNull('parent_id')->with('children')->get());
        });

        if (!function_exists('format_price')) {
            function format_price($price)
            {
                return '$ ' . number_format($price, 2);
            }
        }

        // --- Contenido de EventServiceProvider ---
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                Event::listen($event, $listener);
            }
        }

        foreach ($this->observers as $model => $observers) {
            foreach ((array) $observers as $observer) {
                $model::observe($observer);
            }
        }

        // --- Contenido de RouteServiceProvider ---
        $this->configureRateLimiting();

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Configure the rate limiters for the application.
     * (Desde RouteServiceProvider)
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     * (Desde EventServiceProvider)
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
