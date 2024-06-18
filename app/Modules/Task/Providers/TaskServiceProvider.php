<?php

namespace App\Modules\Task\Providers;

use App\Modules\Task\Models\Task;
use App\Observers\TaskObserver;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(TaskRouteServiceProvider::class);


    }
}
