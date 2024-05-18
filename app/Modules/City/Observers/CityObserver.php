<?php

namespace App\Modules\City\Observers;

use App\Modules\City\Models\City;

class CityObserver
{
    /**
     * Handle the City "created" event.
     */
    public function created(City $city): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $city->created_by = $user->id;
        // }
        $city->created_by = 1;
        
    }

    /**
     * Handle the City "updated" event.
     */
    public function updated(City $city): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $city->updated_at = $user->id;
        // }

        $city->updated_at = 1;
    }

    /**
     * Handle the City "deleted" event.
     */
    public function deleted(City $city): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $city->deleted_at = $user->id;
        // }
        $city->deleted_at = 1;
    }

    /**
     * Handle the City "restored" event.
     */
    public function restored(City $city): void
    {
        //
    }

    /**
     * Handle the City "force deleted" event.
     */
    public function forceDeleted(City $city): void
    {
        //
    }
}