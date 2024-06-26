<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {

Route::resource('offers', 'OfferController');
Route::patch('offers/{id}/restore', 'OfferController@restore');
Route::delete('offers/{id}/force-delete', 'OfferController@forceDelete');

});
