<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebFrontendController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [WebFrontendController::class, 'showRegister']);
Route::post('/register-user', [WebFrontendController::class, 'registerUser']);

Route::get('/login', [WebFrontendController::class, 'showLogin']);
Route::post('/login-user', [WebFrontendController::class, 'loginUser']);

Route::get('/tasks-view', [WebFrontendController::class, 'tasksView']);
Route::post('/create-task', [WebFrontendController::class, 'createTask']);
Route::get('/complete-task/{id}', [WebFrontendController::class, 'completeTask']);
Route::get('/delete-task/{id}', [WebFrontendController::class, 'deleteTask']);
Route::get('/logout', function () {
    session()->flush();
    return redirect('/login')->with('message', 'Logged out successfully!');
});


