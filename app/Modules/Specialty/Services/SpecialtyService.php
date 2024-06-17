<?php

namespace App\Modules\Specialty\Services;

use App\Modules\Specialty\Http\Resources\SpecialtyCollection;
use App\Modules\Specialty\Http\Resources\SpecialtyResource;
use App\Modules\Specialty\Models\Specialty;
use App\Services\BaseService;

class SpecialtyService extends BaseService
{
    public function list($request)
    {
        try {


            $query = Specialty::filter();

            $query = $this->withTrashed($query, $request);

            $Specialties = $this->withPagination($query, $request);

            return (new SpecialtyCollection($Specialties))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Countries'));
        }
    }

    public function store($data)
    {
        try {

            $specialty = Specialty::create($data);
            return new SpecialtyResource($specialty);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating Specialty'));
        }
    }

    public function show($id)
    {
        try {

            // $specialty = Specialty::findOrFail($id);
            return new SpecialtyResource(Specialty::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Specialty'));
        }
    }

    public function edit($id)
    {
        try {

            return new SpecialtyResource(Specialty::findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Specialty'));
        }
    }

    public function update($data, $id)
    {
        try {

            $specialty = Specialty::findOrFail($id);
            $specialty->update($data);

            return new SpecialtyResource($specialty);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating Specialty'));
        }
    }

    public function destroy($id)
    {
        try {

            $specialty = Specialty::findOrFail($id);
            $specialty->delete();

            return new SpecialtyResource($specialty);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting Specialty'));
        }
    }

    public function restore($id)
    {
        try {

            $specialty = Specialty::withTrashed()->findOrFail($id);
            $specialty->restore();

            return new SpecialtyResource($specialty);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring Specialty'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $specialty = Specialty::withTrashed()->findOrFail($id);
            $specialty->forceDelete();

            return $specialty;
            // new SpecialtyResource($specialty);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting Specialty'));
        }
    }



}
