<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);
Route::post('worker', [DashboardController::class, 'worker']);
Route::delete('worker', [DashboardController::class, 'deleteWorker']);
