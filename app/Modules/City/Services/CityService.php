<?php

namespace App\Modules\City\Services;

use App\Modules\City\Http\Resources\CityCollection;
use App\Modules\City\Http\Resources\CityResource;
use App\Modules\City\Models\City;
use App\Services\BaseService;

class CityService extends BaseService
{
    public function list($request)
    {
        try {


            $query = City::filter();

            $query = $query->with('country');

            $query = $this->withTrashed($query, $request);

            $cities = $this->withPagination($query, $request);

            return (new CityCollection($cities))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Countries'));
        }
    }

    public function store($data)
    {
        try {

            $city = City::create($data);
            return new CityResource($city);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating City'));
        }
    }

    public function show($id)
    {
        try {

            // $city = City::findOrFail($id);
            return new CityResource(City::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing City'));
        }
    }

    public function edit($id)
    {
        try {

            return new CityResource(City::findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing City'));
        }
    }

    public function update($data, $id)
    {
        try {

            $city = City::findOrFail($id);
            $city->update($data);

            return new CityResource($city);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating City'));
        }
    }

    public function destroy($id)
    {
        try {

            $city = City::findOrFail($id);
            $city->delete();

            return new CityResource($city);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting City'));
        }
    }

    public function restore($id)
    {
        try {

            $city = City::withTrashed()->findOrFail($id);
            if (!$city->trashed()) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'City is not soft-deleted',
                ], 400);
            }
            $city->restore();

            return new CityResource($city);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring City'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $city = City::withTrashed()->findOrFail($id);
            $city->forceDelete();

            return $city;
            // new CityResource($city);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting City'));
        }
    }


}
