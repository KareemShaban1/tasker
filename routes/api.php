<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/sanctum/token', TokenController::class);


Route::group(['prefix' => 'auth'], function () {
    Route::post('userLogin', [AuthController::class, 'userLogin']);
    Route::post('clientLogin', [AuthController::class, 'clientLogin']);
    Route::post('register', [AuthController::class, 'register']);

});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
}
);
