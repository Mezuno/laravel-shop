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

Route::get('/users', App\Http\API\Controllers\User\IndexController::class)->name('user.index');
Route::post('/products', App\Http\API\Controllers\Product\IndexController::class)->name('product.index');
Route::get('/products/filters', App\Http\API\Controllers\Product\FilterListController::class)->name('product.filter.list');
Route::get('/products/{product}', App\Http\API\Controllers\Product\ShowController::class)->where('product', '[0-9]+')->name('product.show');
Route::get('/categories', App\Http\API\Controllers\Category\IndexController::class)->name('category.index');
Route::post('/orders', App\Http\API\Controllers\Order\StoreController::class)->name('order.store');
