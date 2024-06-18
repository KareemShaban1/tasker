<?php

use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->group(function () {

Route::resource('languages', 'LanguageController');
Route::patch('languages/{id}/restore', 'LanguageController@restore');
Route::delete('languages/{id}/force-delete', 'LanguageController@forceDelete');

});
