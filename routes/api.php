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


Route::post('/products', App\Http\API\Controllers\Product\IndexController::class)->name('product.index');
Route::get('/products/main', App\Http\API\Controllers\Product\MainController::class)->name('product.main');
Route::get('/products/filters', App\Http\API\Controllers\Product\FilterListController::class)->name('product.filter.list');
Route::get('/products/{product}', App\Http\API\Controllers\Product\ShowController::class)->where('product', '[0-9]+')->name('product.show');
Route::get('/categories', App\Http\API\Controllers\Category\IndexController::class)->name('category.index');
Route::post('/order', App\Http\API\Controllers\Order\StoreController::class)->name('order.store');
Route::post('/reviews', App\Http\API\Controllers\Review\IndexController::class)->name('review.index');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/orders', App\Http\API\Controllers\Order\IndexController::class)->name('order.index');
    Route::post('/wish', App\Http\API\Controllers\Wishlist\StoreController::class)->name('wish.store');
    Route::post('/wishlist', App\Http\API\Controllers\Wishlist\IndexController::class)->name('wish.index');
    Route::delete('/wish/{wish}/delete', App\Http\API\Controllers\Wishlist\DeleteController::class)->name('wish.delete');
    Route::post('/review', App\Http\API\Controllers\Review\StoreController::class)->name('review.store');
    Route::post('/review/check', App\Http\API\Controllers\Review\CheckController::class)->name('review.check');
});

