<?php

namespace App\Modules\City\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\City\Http\Requests\StoreCityRequest;
use App\Modules\City\Http\Requests\UpdateCityRequest;
use App\Modules\City\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityController extends Controller
{
    public function __construct(public CityService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', City::class);

        $cities = $this->service->list($request);
        if ($cities instanceof JsonResponse) {
            return $cities;
        }

        return $cities->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.users have been retrieved successfully'),
        ]);
        // return $this->returnJSON($cities, __('message.City has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCityRequest $request): JsonResponse
    {
        // $this->authorize('create', City::class);

        $city = $this->service->store($request->all());
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', City::class);

        $city = $this->service->show($id);
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', City::class);

        $city = $this->service->edit($id);
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', City::class);

        $city = $this->service->update($request->validated(), $id);
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', City::class);

        $city = $this->service->destroy($id);
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', City::class);

        $city = $this->service->restore($id);
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', City::class);

        $city = $this->service->forceDelete($id);
        if ($city instanceof JsonResponse) {
            return $city;
        }
        return $this->returnJSON($city, __('message.City has been force deleted successfully'));
    }
}
