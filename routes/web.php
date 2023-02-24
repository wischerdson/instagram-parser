<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::get('workers', [WorkerController::class, 'index']);
Route::post('workers', [WorkerController::class, 'updateOrCreate']);
Route::post('workers/iam', [WorkerController::class, 'iam']);
Route::delete('workers', [WorkerController::class, 'delete']);

Route::get('tasks', [TaskController::class, 'index']);
Route::post('tasks', [TaskController::class, 'create']);
