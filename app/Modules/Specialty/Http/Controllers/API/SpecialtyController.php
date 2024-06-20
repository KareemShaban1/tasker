<?php

namespace App\Modules\Specialty\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Specialty\Http\Requests\StoreSpecialtyRequest;
use App\Modules\Specialty\Http\Requests\UpdateSpecialtyRequest;
use App\Modules\Specialty\Models\Specialty;
use App\Modules\Specialty\Services\SpecialtyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpecialtyController extends Controller
{
    public function __construct(public SpecialtyService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', Specialty::class);

        $specialties = $this->service->list($request);
        if ($specialties instanceof JsonResponse) {
            return $specialties;
        }

        
        return $specialties->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.specialties have been retrieved successfully'),
        ]);
        // return $this->returnJSON($specialties, __('message.Specialty has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecialtyRequest $request): JsonResponse
    {
        // $this->authorize('create', Specialty::class);

        $specialty = $this->service->store($request->all());
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Specialty::class);

        $specialty = $this->service->show($id);
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Specialty::class);

        $specialty = $this->service->edit($id);
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialtyRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Specialty::class);

        $specialty = $this->service->update($request->validated(), $id);
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Specialty::class);

        $specialty = $this->service->destroy($id);
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Specialty::class);

        $specialty = $this->service->restore($id);
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Specialty::class);

        $specialty = $this->service->forceDelete($id);
        if ($specialty instanceof JsonResponse) {
            return $specialty;
        }
        return $this->returnJSON($specialty, __('message.Specialty has been force deleted successfully'));
    }
}
