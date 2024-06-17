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

        $countries = $this->service->list($request);
        if ($countries instanceof JsonResponse) {
            return $countries;
        }

        return $this->returnJSON($countries, __('message.Specialty has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpecialtyRequest $request): JsonResponse
    {
        // $this->authorize('create', Specialty::class);

        $country = $this->service->store($request->all());
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Specialty::class);

        $country = $this->service->show($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Specialty::class);

        $country = $this->service->edit($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpecialtyRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Specialty::class);

        $country = $this->service->update($request->validated(), $id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Specialty::class);

        $country = $this->service->destroy($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Specialty::class);

        $country = $this->service->restore($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Specialty::class);

        $country = $this->service->forceDelete($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Specialty has been force deleted successfully'));
    }
}
