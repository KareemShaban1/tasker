<?php

namespace App\Modules\State\Services;

use App\Modules\State\Http\Resources\StateCollection;
use App\Modules\State\Http\Resources\StateResource;
use App\Modules\State\Models\State;
use App\Services\BaseService;

class StateService extends BaseService
{
    public function list($request)
    {
        try {


            $query = State::filter();

            $query = $query->with('city');

            $query = $this->withTrashed($query, $request);

            $states = $this->withPagination($query, $request);

            return (new StateCollection($states))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching states'));
        }
    }

    public function store($data)
    {
        try {

            $state = State::create($data);
            return new StateResource($state);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating State'));
        }
    }

    public function show($id)
    {
        try {

            // $state = State::findOrFail($id);
            return new StateResource(State::with('city')->findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing State'));
        }
    }

    public function edit($id)
    {
        try {

            return new StateResource(State::with('city')->findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing State'));
        }
    }

    public function update($data, $id)
    {
        try {

            $state = State::findOrFail($id);
            $state->update($data);

            return new StateResource($state);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating State'));
        }
    }

    public function destroy($id)
    {
        try {

            $state = State::findOrFail($id);
            $state->delete();

            return new StateResource($state);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting State'));
        }
    }

    public function restore($id)
    {
        try {

            $state = State::withTrashed()->findOrFail($id);
            $state->restore();

            return new StateResource($state);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring State'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $state = State::withTrashed()->findOrFail($id);
            $state->forceDelete();

            return $state;
            // new StateResource($state);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting State'));
        }
    }


}
