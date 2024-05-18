<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Blueprint::macro('withAuditFields', function () {
            $this->unsignedBigInteger('created_by')->nullable();
            $this->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $this->unsignedBigInteger('updated_by')->nullable();
            $this->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $this->unsignedBigInteger('deleted_by')->nullable();
            $this->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $this->timestamps();
            $this->softDeletes();
        });

        Blueprint::macro('withLocationFields', function () {
            $this->longText('location');
            $this->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $this->foreignId('city_id')->constrained('cities')->cascadeOnDelete();
            $this->foreignId('state_id')->constrained('states')->cascadeOnDelete();
        });

        Builder::macro('search', function ($property, $value) {
            return $this->where($property, 'LIKE', "%" . $value . "%");
        });


    }
}