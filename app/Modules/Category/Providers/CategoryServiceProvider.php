<?php

namespace App\Modules\Category\Providers;

use App\Modules\Category\Models\Category;
use App\Modules\Category\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(CategoryRouteServiceProvider::class);

        Category::observe(CategoryObserver::class);


    }
}