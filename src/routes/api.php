<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\OrderController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {

    Route::get('/products', [ProductController::class, 'index']);

    Route::get('/categories/{id}', [ProductCategoryController::class, 'index']);

    Route::get('/customers/{id}/order', [OrderController::class, 'index']);

    Route::get('/customers/{id}/order/addProduct/{productId}', [OrderController::class, 'addProduct']);

    Route::get('/customers/{id}/order/removeProduct/{productId}', [OrderController::class, 'removeProduct']);

    Route::get('/customers/{id}/order/place', [OrderController::class, 'placeOrder']);

});
