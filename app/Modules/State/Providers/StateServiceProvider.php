<?php

namespace App\Modules\State\Providers;

use App\Modules\State\Models\State;
use App\Modules\State\Observers\StateObserver;
use Illuminate\Support\ServiceProvider;

class StateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(StateRouteServiceProvider::class);

        State::observe(StateObserver::class);

    }
}