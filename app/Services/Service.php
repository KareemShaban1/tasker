<?php

namespace App\Services;

class Service extends BaseService
{
    public function list($request)
    {
        try {



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching users'));
        }
    }

    public function store($request)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating user'));
        }
    }

    public function show($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing user'));
        }
    }

    public function update($request, $id)
    {
        try {



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating user'));
        }
    }

    public function destroy($id)
    {
        try {


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting user'));
        }
    }

    public function restore($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring user'));
        }
    }

    public function forceDelete($id)
    {
        try {

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting user'));
        }
    }

}