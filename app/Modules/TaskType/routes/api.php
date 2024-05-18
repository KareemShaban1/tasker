<?php

use Illuminate\Support\Facades\Route;

Route::resource('taskTypes', 'TaskTypeController');
Route::patch('taskTypes/{id}/restore', 'TaskTypeController@restore');
Route::delete('taskTypes/{id}/force-delete', 'TaskTypeController@forceDelete');