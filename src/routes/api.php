<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('users', 'getUsers');
    Route::get('loggedUser', 'loggedUser');

});

Route::controller(ProjectController::class)->group(function () {
    Route::get('project', 'index');
    Route::post('project', 'store');
    Route::get('project/{id}', 'show');
    Route::put('project/{id}', 'update');
    Route::delete('project/{id}', 'destroy');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('task', 'store');
    Route::post('task/{id}/updateStatus', 'updateStatus');
});
