<?php

declare(strict_types=1);

namespace App\Providers;

use Fanzo\ServiceCommon\Http\Providers\FanzoAppServiceProvider;

class AppServiceProvider extends FanzoAppServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment(['local', 'staging'])) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
