<?php

namespace App\Modules\TaskType\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\TaskType\Http\Requests\StoreTaskTypeRequest;
use App\Modules\TaskType\Http\Requests\UpdateTaskTypeRequest;
use App\Modules\TaskType\Services\TaskTypeService;
use App\TaskType\Models\TaskType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskTypeController extends Controller
{
    public function __construct(public TaskTypeService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', TaskType::class);

        $taskTypes = $this->service->list($request);
        if ($taskTypes instanceof JsonResponse) {
            return $taskTypes;
        }

        // return $this->returnJSON($taskTypes, __('message.taskType has been created successfully'));

        return $taskTypes->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.TaskTypes have been retrieved successfully'),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskTypeRequest $request): JsonResponse
    {
        // $this->authorize('create', TaskType::class);

        $taskType = $this->service->store($request->all());
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', TaskType::class);

        $taskType = $this->service->show($id);
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', TaskType::class);

        $taskType = $this->service->edit($id);
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskTypeRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', TaskType::class);

        $taskType = $this->service->update($request->validated(), $id);
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', TaskType::class);

        $taskType = $this->service->destroy($id);
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', TaskType::class);

        $taskType = $this->service->restore($id);
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', TaskType::class);

        $taskType = $this->service->forceDelete($id);
        if ($taskType instanceof JsonResponse) {
            return $taskType;
        }
        return $this->returnJSON($taskType, __('message.taskType has been force deleted successfully'));
    }
}
