<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::prefix('workers')->group(function () {
	Route::get('/', [WorkerController::class, 'index']);
	Route::get('create', [WorkerController::class, 'create']);
	Route::post('/', [WorkerController::class, 'store']);
	Route::post('iam', [WorkerController::class, 'storeViaIam']);
	Route::any('load', [WorkerController::class, 'load']);
	Route::get('{id}', [WorkerController::class, 'edit']);
	Route::put('{id}', [WorkerController::class, 'update']);
	Route::delete('{id}', [WorkerController::class, 'delete']);
});

Route::get('worker-healthcheck/{id}', [WorkerController::class, 'healthcheck']);

Route::get('tasks', [TaskController::class, 'index']);
Route::post('tasks', [TaskController::class, 'create']);
