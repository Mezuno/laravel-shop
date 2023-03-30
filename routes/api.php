<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/users', \App\Http\Controllers\API\User\IndexController::class)->name('user.index');
Route::post('/products', \App\Http\Controllers\API\Product\IndexController::class)->name('product.index');
Route::get('/products/filters', \App\Http\Controllers\API\Product\FilterListController::class)->name('product.filter.list');
Route::get('/products/{product}', \App\Http\Controllers\API\Product\ShowController::class)->where('product', '[0-9]+')->name('product.show');
Route::get('/categories', \App\Http\Controllers\API\Category\IndexController::class)->name('category.index');
Route::post('/orders', \App\Http\Controllers\API\Order\StoreController::class)->name('order.store');
