<?php

namespace App\Modules\Offer\Providers;

use Illuminate\Support\ServiceProvider;

class OfferServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(OfferRouteServiceProvider::class);


    }
}
