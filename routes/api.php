<?php

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

Route::name('api.')->group(function() {

    Route::apiResource('products', \App\Http\Controllers\API\ProductController::class)->only('index', 'show');
    Route::apiResource('categories', \App\Http\Controllers\API\CategoryController::class)->only('index', 'show');

    Route::middleware('guest:sanctum')->group(function() {
        Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register'])->name('register');
        Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login'])->name('login');
    });
    Route::middleware('auth:sanctum')->group(function() {
       Route::apiResource('products', \App\Http\Controllers\API\ProductController::class)->except('index', 'show');
       Route::apiResource('categories', \App\Http\Controllers\API\CategoryController::class)->except('index', 'show');
    });
});
