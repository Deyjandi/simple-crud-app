<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Auth Routes
    |--------------------------------------------------------------------------
    */

    // Get authenticated user
    Route::get('user',                      [AuthController::class, 'user']);

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    // Create
    Route::post('users',                    [UserController::class, 'store']);
    // Read
    Route::get('users',                     [UserController::class, 'index']);
    Route::get('users/{userId}',            [UserController::class, 'show']);
    // Update
    Route::patch('users/{user}',            [UserController::class, 'update']);
    // Delete
    Route::delete('users/{user}',           [UserController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Department Routes
    |--------------------------------------------------------------------------
    */

    // Create
    Route::post('departments',                      [DepartmentController::class, 'store']);
    // Read
    Route::get('departments',                       [DepartmentController::class, 'index']);
    Route::get('departments/{department}',          [DepartmentController::class, 'show']);
    // Update
    Route::patch('departments/{department}',        [DepartmentController::class, 'update']);
    // Delete
    Route::delete('departments/{department}',       [DepartmentController::class, 'destroy']);
});
