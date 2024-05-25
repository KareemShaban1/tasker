<?php

namespace App\Modules\Country\Services;

use App\Modules\Country\Http\Resources\CountryCollection;
use App\Modules\Country\Http\Resources\CountryResource;
use App\Modules\Country\Models\Country;
use App\Services\BaseService;

class CountryService extends BaseService
{
    public function list($request)
    {
        try {


            $query = Country::query();

            // $query = $query->with('');

            $query = $this->withTrashed($query, $request);

            $countries = $this->withPagination($query, $request);

            return (new CountryCollection($countries))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Countries'));
        }
    }

    public function store($data)
    {
        try {

            $country = Country::create($data);
            return new CountryResource($country);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating Country'));
        }
    }

    public function show($id)
    {
        try {

            // $country = Country::findOrFail($id);
            return new CountryResource(Country::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Country'));
        }
    }

    public function edit($id)
    {
        try {

            return new CountryResource(Country::findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Country'));
        }
    }

    public function update($data, $id)
    {
        try {

            $country = Country::findOrFail($id);
            $country->update($data);

            return new CountryResource($country);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating Country'));
        }
    }

    public function destroy($id)
    {
        try {

            $country = Country::findOrFail($id);
            $country->delete();

            return new CountryResource($country);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting Country'));
        }
    }

    public function restore($id)
    {
        try {

            $country = Country::withTrashed()->findOrFail($id);
            $country->restore();

            return new CountryResource($country);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring Country'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $country = Country::findOrFail($id);
            $country->forceDelete();

            return new CountryResource($country);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting Country'));
        }
    }


}