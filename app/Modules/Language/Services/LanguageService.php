<?php

namespace App\Modules\Language\Services;

use App\Modules\Language\Http\Resources\LanguageCollection;
use App\Modules\Language\Http\Resources\LanguageResource;
use App\Modules\Language\Models\Language;
use App\Services\BaseService;

class LanguageService extends BaseService
{
    public function list($request)
    {
        try {


            $query = Language::query();

            // $query = $query->with('');

            $query = $this->withTrashed($query, $request);

            $languages = $this->withPagination($query, $request);

            return (new LanguageCollection($languages))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Languages'));
        }
    }

    public function store($data)
    {
        try {

            $Language = Language::create($data);
            return new LanguageResource($Language);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating Language'));
        }
    }

    public function show($id)
    {
        try {

            // $Language = Language::findOrFail($id);
            return new LanguageResource(Language::with('language')->findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Language'));
        }
    }

    public function edit($id)
    {
        try {

            return new LanguageResource(Language::with('language')->findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Language'));
        }
    }

    public function update($data, $id)
    {
        try {

            $language = Language::findOrFail($id);
            $language->update($data);

            return new LanguageResource($language);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating Language'));
        }
    }

    public function destroy($id)
    {
        try {

            $Language = Language::findOrFail($id);
            $Language->delete();

            return new LanguageResource($Language);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting Language'));
        }
    }

    public function restore($id)
    {
        try {

            $Language = Language::withTrashed()->findOrFail($id);
            $Language->restore();

            return new LanguageResource($Language);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring Language'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $Language = Language::findOrFail($id);
            $Language->forceDelete();

            return new LanguageResource($Language);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting Language'));
        }
    }


}