<?php

namespace App\Modules\Offer\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Offer\Http\Requests\StoreOfferRequest;
use App\Modules\Offer\Http\Requests\UpdateOfferRequest;
use App\Modules\Offer\Services\OfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfferController extends Controller
{
    public function __construct(public OfferService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {

        $offers = $this->service->list($request);
        if ($offers instanceof JsonResponse) {
            return $offers;
        }

        return $this->returnJSON($offers, __('message.Offers has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request): JsonResponse
    {
        // $this->authorize('create', Offer::class);

        $offer = $this->service->store($request->all());
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Offer::class);

        $offer = $this->service->show($id);
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Offer::class);

        $offer = $this->service->edit($id);
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, $id): JsonResponse
    {

        $offer = $this->service->update($request->all(), $id);
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Offer::class);

        $offer = $this->service->destroy($id);
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Offer::class);

        $offer = $this->service->restore($id);
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Offer::class);

        $offer = $this->service->forceDelete($id);
        if ($offer instanceof JsonResponse) {
            return $offer;
        }
        return $this->returnJSON($offer, __('message.Offer has been force deleted successfully'));
    }
}
