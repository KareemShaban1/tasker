<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $modulePaths = glob(app_path('Modules/*'), GLOB_ONLYDIR);
        foreach ($modulePaths as $modulePath) {
            $moduleName = basename($modulePath);
            $providerClassName = 'App\Modules\\' . $moduleName . '\Providers\\' . $moduleName . 'ServiceProvider';

            if (class_exists($providerClassName)) {
                $this->app->register($providerClassName);
            }
        }
    }
}
