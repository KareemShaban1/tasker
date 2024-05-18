<?php

namespace App\Modules\Language\Observers;

use App\Modules\Language\Models\Language;

class LanguageObserver
{
    /**
     * Handle the Language "created" event.
     */
    public function created(Language $Language): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $Language->created_by = $user->id;
        // }
        $Language->created_by = 1;
        
    }

    /**
     * Handle the Language "updated" event.
     */
    public function updated(Language $Language): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $Language->updated_at = $user->id;
        // }

        $Language->updated_at = 1;
    }

    /**
     * Handle the Language "deleted" event.
     */
    public function deleted(Language $Language): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $Language->deleted_at = $user->id;
        // }
        $Language->deleted_at = 1;
    }

    /**
     * Handle the Language "restored" event.
     */
    public function restored(Language $Language): void
    {
        //
    }

    /**
     * Handle the Language "force deleted" event.
     */
    public function forceDeleted(Language $Language): void
    {
        //
    }
}