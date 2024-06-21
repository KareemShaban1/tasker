<?php

namespace App\Modules\User\Services;

use App\Modules\User\Http\Resources\UserCollection;
use App\Modules\User\Http\Resources\UserResource;
use App\Modules\User\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService
{
    public function list($request)
    {
        try {


            $query = User::filter();

            // $query = $query->with('country');

            $query = $this->withTrashed($query, $request);

            $cities = $this->withPagination($query, $request);

            return (new UserCollection($cities))->withFullData(!($request->full_data == 'false'));



        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while fetching Countries'));
        }
    }

    public function store($request)
    {
        try {

            $data = $request->validated();
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            return new UserResource($user);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while creating User'));
        }
    }

    public function show($id)
    {
        try {

            // $user = User::findOrFail($id);
            return new UserResource(User::findOrFail($id));
        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing User'));
        }
    }

    public function edit($id)
    {
        try {

            return new UserResource(User::findOrFail($id));


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while showing User'));
        }
    }

    public function update($request, $id)
    {
        try {

            $user = User::findOrFail($id);
            $data = $request->validated();
            $data['password'] = Hash::make($request->password);
            $user->update($data);
            return new UserResource($user);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while updating User'));
        }
    }

    public function destroy($id)
    {
        try {

            $user = User::findOrFail($id);
            $user->delete();

            return new UserResource($user);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while deleting User'));
        }
    }

    public function restore($id)
    {
        try {

            $user = User::withTrashed()->findOrFail($id);
            if (!$user->trashed()) {
                return response()->json([
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'User is not soft-deleted',
                ], 400);
            }
            $user->restore();

            return new UserResource($user);

        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while restoring User'));
        }
    }

    public function forceDelete($id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->forceDelete();

            return $user;
            // new UserResource($user);


        } catch (\Exception $e) {
            return $this->handleException($e, __('message.Error happened while force deleting User'));
        }
    }


}
