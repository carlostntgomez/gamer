<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Observers\OrderObserver;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
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
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Order::observe(OrderObserver::class);
        Product::observe(ProductObserver::class);

        Paginator::useBootstrapFive();

        if (!function_exists('format_price')) {
            function format_price($price)
            {
                return '$ ' . number_format($price, 2);
            }
        }
    }
}
