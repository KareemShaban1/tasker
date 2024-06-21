<?php

namespace App\Modules\Category\Services;

use App\Modules\Category\Http\Resources\CategoryCollection;
use App\Modules\Category\Http\Resources\CategoryResource;
use App\Modules\Category\Models\Category;
use App\Services\BaseService;

class CategoryService extends BaseService
{
    public function list($request)
    {
        try {


            $query = Category::filter();

            $query = $this->withTrashed($query, $request);

            $categories = $this->withPagination($query, $request);

            return (new CategoryCollection($categories))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Countries'));
        }
    }

    public function store($data)
    {
        try {

            $category = Category::create($data);
            return new CategoryResource($category);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating Category'));
        }
    }

    public function show($id)
    {
        try {
            return new CategoryResource(Category::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Category'));
        }
    }

    public function edit($id)
    {
        try {

            return new CategoryResource(Category::findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Category'));
        }
    }

    public function update($data, $id)
    {
        try {

            $category = Category::findOrFail($id);
            $category->update($data);

            return new CategoryResource($category);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating Category'));
        }
    }

    public function destroy($id)
    {
        try {

            $category = Category::findOrFail($id);
            $category->delete();

            return new CategoryResource($category);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting Category'));
        }
    }

    public function restore($id)
    {
        try {

            $category = Category::withTrashed()->findOrFail($id);
            if (!$category->trashed()) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Category is not soft-deleted',
                ], 400);
            }
            $category->restore();

            return new CategoryResource($category);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring Category'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->forceDelete();
            return $category;
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting Category'));
        }
    }



}
