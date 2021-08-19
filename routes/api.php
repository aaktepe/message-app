<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\AuthController;
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
//Public Routes
Route::post('/messages', [MessageController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);

//Private Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/search/{message}', [MessageController::class, 'search']);
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
