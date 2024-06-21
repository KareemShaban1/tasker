<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

Route::resource('cities', 'CityController');
Route::patch('cities/{id}/restore', 'CityController@restore');
Route::delete('cities/{id}/force-delete', 'CityController@forceDelete');

});
