<?php

namespace App\Modules\City\Providers;

use App\Modules\City\Models\City;
use App\Modules\City\Observers\CityObserver;
use Illuminate\Support\ServiceProvider;

class CityServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(CityRouteServiceProvider::class);

        City::observe(CityObserver::class);

    }
}