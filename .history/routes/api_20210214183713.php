<?php

use App\Http\Controllers\ArticleController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

// register
// TODO: make the registration real
Route::post('register', function(Request $request) {
    return response()->json($request, 201);
});

//login
Route::post('login', function(Request $request) {
    $credentials = $request->only('email', 'password');

    if(!auth()->attempt($credentials)){
        throw ValidationException::withMessages([
            'email' => 'Invalid credentials'
        ]);
    }

    $request->session()->regenerate();

    return response()->json(null, 201);
});

// log out

Route::post('logout', function(Request $request) {
    auth()->guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return response()->json(null, 200);
});

Route::get('articles', 'ArticleController@index');
Route::post('articles', 'ArticleController@store');
Route::put('articles/{id}', 'ArticleController@update');
Route::delete('articles/{id}', 'ArticleController@destroy');


Route::get('articles', [ArticleController::class, 'index']);
Route::get('article/{slug}', [ArticleController::class, 'show']);
Route::put('articles/{id}', [ArticleController::class, 'update']);
