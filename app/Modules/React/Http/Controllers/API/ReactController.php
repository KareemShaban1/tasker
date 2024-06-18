<?php

namespace App\Modules\React\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Modules\React\Http\Requests\StoreReactRequest;
use App\Modules\React\Http\Requests\UpdateReactRequest;
use App\Modules\React\Services\ReactService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReactController extends Controller
{

    public function __construct(public ReactService $service) // Pass both services to the constructor
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $reacts = $this->service->list($request);

        if ($reacts instanceof JsonResponse) {
            return $reacts;
        }

        return $this->returnJSON($reacts, 'All Reacts');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReactRequest $request)
    {
        $react = $this->service->store($request->validated());

        if ($react instanceof JsonResponse) {
            return $react;
        }


        return $this->returnJSON($react, 'React Stored Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $react = $this->service->show($id);

        if ($react instanceof JsonResponse) {
            return $react;
        }
        return $react ? $this->returnJSON($react, 'React Showed') : $this->returnJSON(null, 'React Not Found', 'failed', 404);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReactRequest $request, $id)
    {
        $react = $this->service->update($request, $id);

        if ($react instanceof JsonResponse) {
            return $react;
        }

        return $react ? $this->returnJSON($react, 'React Updated Successfully') : $this->returnJSON(null, 'React Not Found', 'failed', 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $react = $this->service->destroy($id);

        if ($react instanceof JsonResponse) {
            return $react;
        }

        return $react ? $this->returnJSON($react, 'React Deleted Successfully') : $this->returnJSON(null, 'React Not Found', 'failed', 404);
    }
}
