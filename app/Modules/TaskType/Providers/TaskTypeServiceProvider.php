<?php

namespace App\Modules\TaskType\Providers;

use App\Modules\TaskType\Models\TaskType;
use App\Modules\TaskType\Observers\TaskTypeObserver;
use Illuminate\Support\ServiceProvider;

class TaskTypeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(TaskTypeRouteServiceProvider::class);

        TaskType::observe(TaskTypeObserver::class);


    }
}