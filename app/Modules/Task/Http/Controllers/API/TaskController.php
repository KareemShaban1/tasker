<?php

namespace App\Modules\Task\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Task\Services\TaskService;
use App\Modules\Task\Http\Requests\StoreTaskRequest;
use App\Modules\Task\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskController extends Controller
{
    public function __construct(public TaskService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', Task::class);

        $tasks = $this->service->list($request);
        if ($tasks instanceof JsonResponse) {
            return $tasks;
        }

        // return $this->returnJSON($tasks, __('message.task has been created successfully'));

        return $tasks->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.tasks have been retrieved successfully'),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        // $this->authorize('create', Task::class);

        $task = $this->service->store($request);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Task::class);

        $task = $this->service->show($id);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Task::class);

        $task = $this->service->edit($id);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Task::class);

        $task = $this->service->update($request, $id);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Task::class);

        $task = $this->service->destroy($id);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Task::class);

        $task = $this->service->restore($id);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Task::class);

        $task = $this->service->forceDelete($id);
        if ($task instanceof JsonResponse) {
            return $task;
        }
        return $this->returnJSON($task, __('message.task has been force deleted successfully'));
    }
}
