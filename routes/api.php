<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;


//Route::middleware(['jwt.auth'])->group(static function () {

Route::prefix('job-posts')->group(function () {
    Route::get('/', [JobPostController::class, 'index']);
    Route::get('/{uid}', [JobPostController::class, 'show']);
    Route::post('/', [JobPostController::class, 'store']);
    Route::put('{uid}/update', [JobPostController::class, 'update']);
    Route::delete('{uid}', [JobPostController::class, 'destroy']);
});

Route::prefix('applications')->group(function () {
    Route::get('/', [ApplicationController::class, 'index']);
    Route::get('/{uid}', [ApplicationController::class, 'show']);
    Route::post('/', [ApplicationController::class, 'store']);
    Route::put('{uid}/update', [ApplicationController::class, 'update']);
    Route::delete('{uid}', [ApplicationController::class, 'destroy']);
});

Route::prefix('candidates')->group(function () {
    Route::get('/', [CandidateController::class, 'index']);
    Route::get('/{uid}', [CandidateController::class, 'show']);
    Route::post('/', [CandidateController::class, 'store']);
    Route::put('{uid}/update', [CandidateController::class, 'update']);
    Route::delete('{uid}', [CandidateController::class, 'destroy']);
});

Route::prefix('tenants')->group(function () {
    Route::get('/', [TenantController::class, 'index']);
    Route::get('/{uid}', [TenantController::class, 'show']);
    Route::post('/', [TenantController::class, 'store']);
    Route::put('{uid}/update', [TenantController::class, 'update']);
    Route::delete('{uid}', [TenantController::class, 'destroy']);
});

//});
