<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::post('/login', AuthController::class);
Route::post('register', [AuthController::class, 'register']);
Route::post('/forgot', [ForgotPasswordController::class, 'forgot']);
Route::post('/reset', [ResetPasswordController::class, 'reset']);
Route::post('logout', [AuthController::class, 'logout']);

// Users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
//    Route::post('/users', [UserController::class, 'store']);
//    Route::put('/users/{id}', [UserController::class, 'update']);
//    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});
