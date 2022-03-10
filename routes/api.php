<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ShortenerController;

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

Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('list', [ShortenerController::class, 'index']);
    Route::post('shortener', [ShortenerController::class, 'store']);
    Route::post('get-data', [ShortenerController::class, 'show']);
    Route::post('custom-url', [ShortenerController::class, 'custom_url']);
    Route::post('destroy', [ShortenerController::class, 'destroy']);
});