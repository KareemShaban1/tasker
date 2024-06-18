<?php

use Illuminate\Support\Facades\Route;


// Route::middleware('auth:sanctum')->group(function () {

Route::resource('countries', 'CountryController');
Route::patch('countries/{id}/restore', 'CountryController@restore');
Route::delete('countries/{id}/force-delete', 'CountryController@forceDelete');

// });
