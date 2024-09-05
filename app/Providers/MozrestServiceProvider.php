<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\BookingService;
use Illuminate\Support\ServiceProvider;

class MozrestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->singleton(
            BookingService::class,
            fn() => new BookingService(
                config('services.mozrest.appUrl'),
                app()->isProduction() ? config('services.mozrest.prodKey') : config('services.mozrest.sandboxKey'),
                config('services.mozrest.timeout'),
                config('services.mozrest.retry'),
            )
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       //
    }
}
