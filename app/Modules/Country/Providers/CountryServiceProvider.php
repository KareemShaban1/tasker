<?php

namespace App\Modules\Country\Providers;

use App\Modules\Country\Models\Country;
use App\Modules\Country\Observers\CountryObserver;
use Illuminate\Support\ServiceProvider;

class CountryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(CountryRouteServiceProvider::class);

        Country::observe(CountryObserver::class);

    }
}