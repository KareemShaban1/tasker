<?php

namespace App\Modules\Task\Services;

use App\Traits\UploadImageTrait;
use App\Traits\UploadVideoTrait;
use App\Modules\Task\Http\Resources\TaskCollection;
use App\Modules\Task\Http\Resources\TaskResource;
use App\Modules\Task\Models\Task;
use App\Services\BaseService;

class TaskService extends BaseService
{
    use UploadImageTrait;
    use UploadVideoTrait;

    public function list($request)
    {
        try {


            $query = Task::with(['client','language','country','city','state'])->filter();

            $query = $this->withTrashed($query, $request);

            $tasks = $this->withPagination($query, $request);

            return (new TaskCollection($tasks))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching tasks'));
        }
    }

    public function store($data)
    {
        try {

            $validatedData = $data->validated();
            $validatedData["image"] = $this->processImage($data, 'image', 'tasks');
            $validatedData["video"] = $this->processVideo($data, 'video', 'tasks');
            $task = Task::create($validatedData);

            // $task = Task::create($data);
            return new TaskResource($task);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating task'));
        }
    }

    public function show($id)
    {
        try {

            return new TaskResource(Task::with(['client','language','country','city','state'])->findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing task'));
        }
    }

    public function edit($id)
    {
        try {

            return new TaskResource(Task::with(['client','language','country','city','state'])->findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing task'));
        }
    }

    public function update($data, $id)
    {
        try {
            $task = Task::findOrFail($id);

            $validatedData = $data->validated();
            $validatedData["image"] = $this->processImage($data, 'image', 'tasks');
            $validatedData["video"] = $this->processVideo($data, 'video', 'tasks');

            $task->update($validatedData);

            return new TaskResource($task);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating task'));
        }
    }

    public function destroy($id)
    {
        try {

            $task = Task::findOrFail($id);
            $task->delete();

            return new TaskResource($task);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting task'));
        }
    }

    public function restore($id)
    {
        try {

            $task = Task::withTrashed()->findOrFail($id);
            $task->restore();

            return new TaskResource($task);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring task'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $task = Task::withTrashed()->findOrFail($id);
            $task->forceDelete();

            return $task;
            // new TaskResource($task);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting task'));
        }
    }

}
