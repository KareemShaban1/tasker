<?php

namespace App\Modules\State\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class StateRouteServiceProvider extends BaseRouteServiceProvider
{
    public $namespace = 'App\Modules\State\Http\Controllers\API';

    public function map()
    {
        $this->mapApiRoutes();
    }

    public function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/api.php');
    }
}