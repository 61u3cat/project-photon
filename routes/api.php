<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);

    Route::post('/tasks', [TaskController::class, 'store'])
        ->middleware('role:admin');

    Route::patch('/tasks/{id}/complete', [TaskController::class, 'markComplete'])
        ->middleware('role:user');

    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
        ->middleware('role:admin');
});