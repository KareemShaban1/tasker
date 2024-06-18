<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

Route::resource('categories', 'CategoryController');
Route::patch('categories/{id}/restore', 'CategoryController@restore');
Route::delete('categories/{id}/force-delete', 'CategoryController@forceDelete');

});
