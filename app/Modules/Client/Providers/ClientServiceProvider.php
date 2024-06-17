<?php

namespace App\Modules\Client\Providers;

use App\Modules\Client\Models\Client;
use App\Observers\ClientObserver;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(ClientRouteServiceProvider::class);


    }
}
