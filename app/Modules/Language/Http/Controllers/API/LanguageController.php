<?php

namespace App\Modules\Language\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Language\Http\Requests\StoreLanguageRequest;
use App\Modules\Language\Http\Requests\UpdateLanguageRequest;
use App\Modules\Language\Services\LanguageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LanguageController extends Controller
{
    public function __construct(public LanguageService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', Language::class);

        $Languages = $this->service->list($request);
        if ($Languages instanceof JsonResponse) {
            return $Languages;
        }

        return $this->returnJSON($Languages, __('message.Language has been created successfully'));

        // return $Languages->additional([
        //     'code' => 200,
        //     'status' => 'success',
        //     'message' =>  __('message.Languages have been retrieved successfully'),
        // ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguageRequest $request): JsonResponse
    {
        // $this->authorize('create', Language::class);

        $Language = $this->service->store($request->all());
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Language::class);

        $Language = $this->service->show($id);
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Language::class);

        $Language = $this->service->edit($id);
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Language::class);

        $Language = $this->service->update($request->validated(), $id);
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Language::class);

        $Language = $this->service->destroy($id);
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Language::class);

        $Language = $this->service->restore($id);
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Language::class);

        $Language = $this->service->forceDelete($id);
        if ($Language instanceof JsonResponse) {
            return $Language;
        }
        return $this->returnJSON($Language, __('message.Language has been force deleted successfully'));
    }
}