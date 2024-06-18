<?php

namespace App\Modules\TaskType\Observers;

use App\Modules\TaskType\Models\TaskType;

class TaskTypeObserver
{
    /**
     * Handle the TaskType "created" event.
     */
    public function created(TaskType $taskType): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $taskType->created_by = $user->id;
        // }
        $taskType->created_by = 1;
        
    }

    /**
     * Handle the TaskType "updated" event.
     */
    public function updated(TaskType $taskType): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $taskType->updated_at = $user->id;
        // }

        $taskType->updated_at = 1;
    }

    /**
     * Handle the TaskType "deleted" event.
     */
    public function deleted(TaskType $taskType): void
    {
        //
        // $user = Auth::user();
        // if ($user) {
        //     $taskType->deleted_at = $user->id;
        // }
        $taskType->deleted_at = 1;
    }

    /**
     * Handle the TaskType "restored" event.
     */
    public function restored(TaskType $taskType): void
    {
        //
    }

    /**
     * Handle the TaskType "force deleted" event.
     */
    public function forceDeleted(TaskType $taskType): void
    {
        //
    }
}
