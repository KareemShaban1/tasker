<?php

namespace App\Modules\Language\Providers;

use App\Modules\Language\Models\Language;
use App\Modules\Language\Observers\LanguageObserver;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(LanguageRouteServiceProvider::class);

        Language::observe(LanguageObserver::class);

    }
}