<?php

use Illuminate\Support\Facades\Route;

Route::resource('specialties', 'SpecialtyController');
Route::patch('specialties/{id}/restore', 'SpecialtyController@restore');
Route::delete('specialties/{id}/force-delete', 'SpecialtyController@forceDelete');
