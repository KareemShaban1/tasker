<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

Route::resource('tasks', 'TaskController');
Route::post('tasks/{id}', 'TaskController@update');
Route::patch('tasks/{id}/restore', 'TaskController@restore');
Route::delete('tasks/{id}/force-delete', 'TaskController@forceDelete');

});
