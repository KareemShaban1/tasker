<?php

namespace App\Modules\Country\Observers;

use App\Modules\Country\Models\Country;

class CountryObserver
{
    /**
     * Handle the Country "created" event.
     */
    public function created(Country $Country): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $Country->created_by = $user->id;
        // }
        $Country->created_by = 1;
        
    }

    /**
     * Handle the Country "updated" event.
     */
    public function updated(Country $Country): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $Country->updated_at = $user->id;
        // }

        $Country->updated_at = 1;
    }

    /**
     * Handle the Country "deleted" event.
     */
    public function deleted(Country $Country): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $Country->deleted_at = $user->id;
        // }
        $Country->deleted_at = 1;
    }

    /**
     * Handle the Country "restored" event.
     */
    public function restored(Country $Country): void
    {
        //
    }

    /**
     * Handle the Country "force deleted" event.
     */
    public function forceDeleted(Country $Country): void
    {
        //
    }
}