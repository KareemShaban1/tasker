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

        $languages = $this->service->list($request);
        if ($languages instanceof JsonResponse) {
            return $languages;
        }

        // return $this->returnJSON($languages, __('message.Language has been created successfully'));

        return $languages->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.languages have been retrieved successfully'),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguageRequest $request): JsonResponse
    {
        // $this->authorize('create', Language::class);

        $language = $this->service->store($request->all());
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Language::class);

        $language = $this->service->show($id);
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Language::class);

        $language = $this->service->edit($id);
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Language::class);

        $language = $this->service->update($request->validated(), $id);
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Language::class);

        $language = $this->service->destroy($id);
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Language::class);

        $language = $this->service->restore($id);
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Language::class);

        $language = $this->service->forceDelete($id);
        if ($language instanceof JsonResponse) {
            return $language;
        }
        return $this->returnJSON($language, __('message.Language has been force deleted successfully'));
    }
}
