<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
Route::resource('clients', 'ClientController');
Route::patch('clients/{id}/restore', 'ClientController@restore');
Route::delete('clients/{id}/force-delete', 'ClientController@forceDelete');
});
