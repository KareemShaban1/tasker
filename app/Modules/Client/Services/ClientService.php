<?php

namespace App\Modules\Client\Services;

use App\Modules\Client\Http\Resources\ClientCollection;
use App\Modules\Client\Http\Resources\ClientResource;
use App\Modules\Client\Models\Client;
use App\Services\BaseService;

class ClientService extends BaseService
{
    public function list($request)
    {
        try {


            $query = Client::filter();

            $query = $query->with('country','city','state');

            $query = $this->withTrashed($query, $request);

            $offers = $this->withPagination($query, $request);

            return (new ClientCollection($offers))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Clients'));
        }
    }

    public function store($data)
    {
        try {

            $client = Client::create($data);
            return new ClientResource($client);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating Client'));
        }
    }

    public function show($id)
    {
        try {

            return new ClientResource(Client::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Client'));
        }
    }

    public function edit($id)
    {
        try {

            return new ClientResource(Client::with('country','city','state')->findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing Client'));
        }
    }

    public function update($data, $id)
    {
        try {

            
            $client = Client::findOrFail($id);
            $client->update($data);

            return new ClientResource($client);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating Client'));
        }
    }

    public function destroy($id)
    {
        try {

            $client = Client::findOrFail($id);
            $client->delete();

            return new ClientResource($client);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting Client'));
        }
    }

    public function restore($id)
    {
        try {

            $client = Client::withTrashed()->findOrFail($id);
            $client->restore();

            return new ClientResource($client);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring Client'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $client = Client::withTrashed()->findOrFail($id);
            $client->forceDelete();

            return $client;
            // new ClientResource($client);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting Client'));
        }
    }


}
