<?php

namespace App\Modules\Category\Observers;

use App\Modules\Category\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $Category): void
    {
        //
        $user = Auth::user();
        if ($user) {
            $Category->created_by = $user->id;
        }
        // $Category->created_by = 1;
        
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $Category): void
    {
        //
        $user = Auth::user();
        if ($user) {
            $Category->updated_at = $user->id;
        }

        // $Category->updated_at = 1;
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $Category): void
    {
        //
        $user = Auth::user();
        if ($user) {
            $Category->deleted_at = $user->id;
        }
        // $Category->deleted_at = 1;
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $Category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $Category): void
    {
        //
    }
}
