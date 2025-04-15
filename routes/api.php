<?php

use App\Http\Controllers\JobsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::get('riders', [JobsController::class, 'nearestRiders'])->name('nearest.riders');
Route::patch('riders/{riderId}/location/update', [JobsController::class, 'updateRiderLocation'])->name('update.rider');
