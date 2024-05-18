<?php

namespace App\Modules\Country\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Country\Http\Requests\StoreCountryRequest;
use App\Modules\Country\Http\Requests\UpdateCountryRequest;
use App\Modules\Country\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryController extends Controller
{
    public function __construct(public CountryService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', Country::class);

        $countries = $this->service->list($request);
        if ($countries instanceof JsonResponse) {
            return $countries;
        }

        return $this->returnJSON($countries, __('message.Country has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        // $this->authorize('create', Country::class);

        $country = $this->service->store($request->all());
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Country::class);

        $country = $this->service->show($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Country::class);

        $country = $this->service->edit($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCountryRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Country::class);

        $country = $this->service->update($request->validated(), $id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Country::class);

        $country = $this->service->destroy($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Country::class);

        $country = $this->service->restore($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Country::class);

        $country = $this->service->forceDelete($id);
        if ($country instanceof JsonResponse) {
            return $country;
        }
        return $this->returnJSON($country, __('message.Country has been force deleted successfully'));
    }
}