<?php

declare(strict_types=1);

namespace App\Providers;

use Fanzo\ServiceCommon\Http\Providers\FanzoBroadcastServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends FanzoBroadcastServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
