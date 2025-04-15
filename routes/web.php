<?php

use App\Http\Controllers\view\JobPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/job-page', [JobPageController::class, 'index'])->name('jobs.page');
