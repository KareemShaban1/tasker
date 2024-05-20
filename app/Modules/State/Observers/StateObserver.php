<?php

namespace App\Modules\State\Observers;

use App\Modules\State\Models\State;

class StateObserver
{
    /**
     * Handle the State "created" event.
     */
    public function created(State $State): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $State->created_by = $user->id;
        // }
        $State->created_by = 1;
        
    }

    /**
     * Handle the State "updated" event.
     */
    public function updated(State $State): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $State->updated_at = $user->id;
        // }

        $State->updated_at = 1;
    }

    /**
     * Handle the State "deleted" event.
     */
    public function deleted(State $State): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $State->deleted_at = $user->id;
        // }
        $State->deleted_at = 1;
    }

    /**
     * Handle the State "restored" event.
     */
    public function restored(State $State): void
    {
        //
    }

    /**
     * Handle the State "force deleted" event.
     */
    public function forceDeleted(State $State): void
    {
        //
    }
}