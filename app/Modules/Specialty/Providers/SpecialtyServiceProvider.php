<?php

namespace App\Modules\Specialty\Providers;

use App\Modules\Specialty\Models\Specialty;
use App\Modules\Specialty\Observers\SpecialtyObserver;
use Illuminate\Support\ServiceProvider;

class SpecialtyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(SpecialtyRouteServiceProvider::class);

        // Specialty::observe(SpecialtyObserver::class);

    }
}
