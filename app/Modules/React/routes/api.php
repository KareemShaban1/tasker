<?php

use App\Modules\React\Http\Controllers\API\ReactController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
          Route::apiResource('/reacts', ReactController::class);
});
