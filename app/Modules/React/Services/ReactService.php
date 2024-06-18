<?php

namespace App\Modules\React\Services;

use App\Modules\React\Models\React;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class ReactService extends BaseService
{
    public function list($request)
    {
        try {

            $reacts = React::all();


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Reacts'));
        }
    }

    public function store($data)
    {
        try {

            $laReact = React::where('React_id', Auth::React()->id)
            ->where('reactable_type', $data["reactable_type"])
            ->where('reactable_id', $data["reactable_id"])
            ->first();

            // If the record already exists, update it; otherwise, create a new one
            if ($laReact) {
                $laReact->update($data);
            } else {
                $laReact = React::create($data);
            }
            return $laReact;

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating React'));
        }
    }

    public function show($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing React'));
        }
    }

    public function update($request, $id)
    {
        try {



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating React'));
        }
    }

    public function destroy($id)
    {
        try {


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting React'));
        }
    }

    public function restore($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring React'));
        }
    }

    public function forceDelete($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting React'));
        }
    }


}
