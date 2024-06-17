<?php

namespace App\Modules\Offer\Services;

use App\Modules\Offer\Http\Resources\OfferCollection;
use App\Modules\Offer\Http\Resources\OfferResource;
use App\Modules\Offer\Models\Offer;
use App\Services\BaseService;

class OfferService extends BaseService
{
    public function list($request)
    {
        try {


            $query = Offer::filter();

            $query = $query->with('task_type','language');

            $query = $this->withTrashed($query, $request);

            $offers = $this->withPagination($query, $request);

            return (new OfferCollection($offers))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Offers'));
        }
    }

    public function store($data)
    {
        try {

            $offer = Offer::create($data);
            return new OfferResource($offer);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating Offer'));
        }
    }

    public function show($id)
    {
        try {

            return new OfferResource(Offer::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Offer'));
        }
    }

    public function edit($id)
    {
        try {

            return new OfferResource(Offer::with('task_type','language')->findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Offer'));
        }
    }

    public function update($data, $id)
    {
        try {

            
            $offer = Offer::findOrFail($id);
            $offer->update($data);

            return new OfferResource($offer);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating Offer'));
        }
    }

    public function destroy($id)
    {
        try {

            $offer = Offer::findOrFail($id);
            $offer->delete();

            return new OfferResource($offer);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting Offer'));
        }
    }

    public function restore($id)
    {
        try {

            $offer = Offer::withTrashed()->findOrFail($id);
            $offer->restore();

            return new OfferResource($offer);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring Offer'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $offer = Offer::withTrashed()->findOrFail($id);
            $offer->forceDelete();

            return $offer;
            // new OfferResource($offer);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting Offer'));
        }
    }


}
