<?php

namespace App\Modules\User\Providers;

use App\Modules\User\Models\User;
use App\Modules\User\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        app()->register(UserRouteServiceProvider::class);


    }
}
