<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

Route::resource('users', 'UserController');
Route::patch('users/{id}/restore', 'UserController@restore');
Route::delete('users/{id}/force-delete', 'UserController@forceDelete');

});
