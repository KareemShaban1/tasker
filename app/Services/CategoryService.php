<?php

namespace App\Services;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;

class CategoryService extends BaseService
{
    public function list($request)
    {
        try {

            $query = Category::query();

            $query = $query->with('parent', 'task_type', 'language');

            $query = $this->withTrashed($query, $request);

            $categories = $this->withPagination($query, $request);

            return (new CategoryCollection($categories))->withFullData(!($request->full_data == 'false'));


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