<?php

namespace App\Modules\React\Providers;

use App\Modules\React\Models\React;
use App\Observers\ReactObserver;
use Illuminate\Support\ServiceProvider;

class ReactServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(ReactRouteServiceProvider::class);


    }
}
