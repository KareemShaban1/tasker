<?php

namespace App\Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\User\Http\Requests\StoreUserRequest;
use App\Modules\User\Http\Requests\UpdateUserRequest;
use App\Modules\User\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserController extends Controller
{
    public function __construct(public UserService $service)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|ResourceCollection
    {
        // $this->authorize('viewAny', User::class);

        $users = $this->service->list($request);
        if ($users instanceof JsonResponse) {
            return $users;
        }

        // return $this->returnJSON($users, __('message.User has been created successfully'));

        return $users->additional([
            'code' => 200,
            'status' => 'success',
            'message' =>  __('message.Users have been retrieved successfully'),
        ]);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        // $this->authorize('create', User::class);

        $user = $this->service->store($request);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been created successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        // $this->authorize('view', User::class);

        $user = $this->service->show($id);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been retrieved successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function edit($id): JsonResponse
    {
        // $this->authorize('update', User::class);

        $user = $this->service->edit($id);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been retrieved successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        // $this->authorize('update', User::class);

        $user = $this->service->update($request, $id);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        // $this->authorize('delete', User::class);

        $user = $this->service->destroy($id);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been deleted successfully'));
    }

    public function restore($id): JsonResponse
    {
        // $this->authorize('restore', User::class);

        $user = $this->service->restore($id);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been restored successfully'));
    }

    public function forceDelete($id): JsonResponse
    {
        // $this->authorize('forceDelete', User::class);

        $user = $this->service->forceDelete($id);
        if ($user instanceof JsonResponse) {
            return $user;
        }
        return $this->returnJSON($user, __('message.User has been force deleted successfully'));
    }
}
