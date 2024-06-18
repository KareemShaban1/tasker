<?php

namespace App\Modules\Client\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\Client\Http\Requests\StoreClientRequest;
use App\Modules\Client\Http\Requests\UpdateClientRequest;
use App\Modules\Client\Services\ClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ClientController extends Controller
{
    public function __construct(public ClientService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', Client::class);

        $cities = $this->service->list($request);
        if ($cities instanceof JsonResponse) {
            return $cities;
        }

        return $this->returnJSON($cities, __('message.Client has been created successfully'));

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        // $this->authorize('create', Client::class);

        $client = $this->service->store($request);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', Client::class);

        $client = $this->service->show($id);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', Client::class);

        $client = $this->service->edit($id);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', Client::class);

        $client = $this->service->update($request->all(), $id);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', Client::class);

        $client = $this->service->destroy($id);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', Client::class);

        $client = $this->service->restore($id);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', Client::class);

        $client = $this->service->forceDelete($id);
        if ($client instanceof JsonResponse) {
            return $client;
        }
        return $this->returnJSON($client, __('message.Client has been force deleted successfully'));
    }
}
