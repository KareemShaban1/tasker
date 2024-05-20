<?php

use Illuminate\Support\Facades\Route;

Route::resource('states', 'StateController');
Route::patch('states/{id}/restore', 'StateController@restore');
Route::delete('states/{id}/force-delete', 'StateController@forceDelete');