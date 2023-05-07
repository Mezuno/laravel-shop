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


Route::get('/products', App\Http\API\Controllers\Product\IndexController::class);
Route::post('/products', App\Http\API\Controllers\Product\FilteredProductsController::class);
Route::get('/products/main', App\Http\API\Controllers\Product\MainController::class);
Route::get('/products/filters', App\Http\API\Controllers\Product\FilterListController::class);
Route::get('/products/{product}', App\Http\API\Controllers\Product\ShowController::class)->where('product', '[0-9]+');
Route::get('/categories', App\Http\API\Controllers\Category\IndexController::class);
Route::post('/order', App\Http\API\Controllers\Order\StoreController::class);
Route::post('/reviews', App\Http\API\Controllers\Review\IndexController::class);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/orders', App\Http\API\Controllers\Order\IndexController::class);
    Route::post('/wish', App\Http\API\Controllers\Wishlist\StoreController::class);
    Route::post('/wishlist', App\Http\API\Controllers\Wishlist\IndexController::class);
    Route::post('/wishlist/sync', App\Http\API\Controllers\Wishlist\SyncController::class);
    Route::delete('/wish/{wish}/delete', App\Http\API\Controllers\Wishlist\DeleteController::class);
    Route::post('/review', App\Http\API\Controllers\Review\StoreController::class);
    Route::post('/review/check', App\Http\API\Controllers\Review\CheckController::class);
});

