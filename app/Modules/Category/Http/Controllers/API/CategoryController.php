<?php

namespace App\Modules\Category\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Category\Http\Requests\StoreCategoryRequest;
use App\Modules\Category\Http\Requests\UpdateCategoryRequest;
use App\Modules\Category\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends Controller
{
    public function __construct(public CategoryService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', Category::class);

        $categories = $this->service->list($request);
        if ($categories instanceof JsonResponse) {
            return $categories;
        }

        return $categories->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.Categories have been retrieved successfully'),
        ]);
        // return $this->returnJSON($categories, __('message.Category has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        // $this->authorize('create', Category::class);

        $category = $this->service->store($request->all());
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Category::class);

        $category = $this->service->show($id);
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Category::class);

        $category = $this->service->edit($id);
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Category::class);

        $category = $this->service->update($request->validated(), $id);
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Category::class);

        $category = $this->service->destroy($id);
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Category::class);

        $category = $this->service->restore($id);
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Category::class);

        $category = $this->service->forceDelete($id);
        if ($category instanceof JsonResponse) {
            return $category;
        }
        return $this->returnJSON($category, __('message.Category has been force deleted successfully'));
    }
}
