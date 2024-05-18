<?php

use Illuminate\Support\Facades\Route;


Route::resource('cities', 'CityController');
Route::patch('cities/{id}/restore', 'CityController@restore');
Route::delete('cities/{id}/force-delete', 'CityController@forceDelete');