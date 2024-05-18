<?php

namespace App\Modules\LaModel\Providers;

use App\Modules\LaModel\Models\LaModel;
use App\Observers\LaModelObserver;
use Illuminate\Support\ServiceProvider;

class LaModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(LaModelRouteServiceProvider::class);


    }
}
