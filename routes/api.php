<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [UserAuthController::class, 'register'])->name('register');
Route::post('login', [UserAuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('users', UserController::class)->except('edit', 'create')->middleware('scope:admin');

    Route::resource('projects', ProjectController::class)->except('edit', 'create')->middleware('scope:product_owner');

    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::get('/', [TaskController::class, 'index'])->name('index')->middleware('scope:product_owner');
        Route::post('/', [TaskController::class, 'store'])->name('store')->middleware('scope:product_owner');
        Route::get('/{task}', [TaskController::class, 'show'])->name('show')->middleware('scope:product_owner,team_member');
        Route::match(['put', 'patch'], '/{task}', [TaskController::class, 'update'])->name('update')->middleware('scope:team_member');
        Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy')->middleware('scope:product_owner');
    });
});
