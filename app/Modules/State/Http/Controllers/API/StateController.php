<?php

namespace App\Modules\State\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\State\Http\Requests\StoreStateRequest;
use App\Modules\State\Http\Requests\UpdateStateRequest;
use App\Modules\State\Services\StateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StateController extends Controller
{
    public function __construct(public StateService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', State::class);

        $states = $this->service->list($request);
        if ($states instanceof JsonResponse) {
            return $states;
        }

        
        return $states->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.states have been retrieved successfully'),
        ]);
        // return $this->returnJSON($states, __('message.State has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStateRequest $request): JsonResponse
    {
        // $this->authorize('create', State::class);

        $state = $this->service->store($request->all());
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', State::class);

        $state = $this->service->show($id);
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', State::class);

        $state = $this->service->edit($id);
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStateRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', State::class);

        $state = $this->service->update($request->validated(), $id);
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', State::class);

        $state = $this->service->destroy($id);
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', State::class);

        $state = $this->service->restore($id);
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', State::class);

        $state = $this->service->forceDelete($id);
        if ($state instanceof JsonResponse) {
            return $state;
        }
        return $this->returnJSON($state, __('message.State has been force deleted successfully'));
    }
}
