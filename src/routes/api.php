<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/categories/{id}', [ProductCategoryController::class, 'index']);

Route::get('/customers/{id}/order', [OrderController::class, 'index']);

Route::get('/customers/{id}/order/addProduct/{productId}', [OrderController::class, 'addProduct']);

Route::get('/customers/{id}/order/removeProduct/{productId}', [OrderController::class, 'removeProduct']);
