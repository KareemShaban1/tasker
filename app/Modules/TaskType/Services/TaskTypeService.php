<?php

namespace App\Modules\TaskType\Services;

use App\Modules\TaskType\Http\Resources\TaskTypeCollection;
use App\Modules\TaskType\Http\Resources\TaskTypeResource;
use App\Modules\TaskType\Models\TaskType;
use App\Services\BaseService;

class TaskTypeService extends BaseService
{
    public function list($request)
    {
        try {


            $query = TaskType::with('language')->filter();

            $query = $this->withTrashed($query, $request);

            $taskTypes = $this->withPagination($query, $request);

            return (new TaskTypeCollection($taskTypes))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching taskTypes'));
        }
    }

    public function store($data)
    {
        try {

            $taskType = TaskType::create($data);
            return new TaskTypeResource($taskType);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating taskType'));
        }
    }

    public function show($id)
    {
        try {

            // $taskType = TaskType::findOrFail($id);
            return new TaskTypeResource(TaskType::with('language')->findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing taskType'));
        }
    }

    public function edit($id)
    {
        try {

            return new TaskTypeResource(TaskType::with('language')->findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing taskType'));
        }
    }

    public function update($data, $id)
    {
        try {

            $taskType = TaskType::findOrFail($id);
            $taskType->update($data);

            return new TaskTypeResource($taskType);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating taskType'));
        }
    }

    public function destroy($id)
    {
        try {

            $taskType = TaskType::findOrFail($id);
            $taskType->delete();

            return new TaskTypeResource($taskType);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting taskType'));
        }
    }

    public function restore($id)
    {
        try {

            $taskType = TaskType::withTrashed()->findOrFail($id);
            $taskType->restore();

            return new TaskTypeResource($taskType);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring taskType'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $taskType = TaskType::withTrashed()->findOrFail($id);
            $taskType->forceDelete();

            return $taskType;
            // new TaskTypeResource($taskType);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting taskType'));
        }
    }


}
