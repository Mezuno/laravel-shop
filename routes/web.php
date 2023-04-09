<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin/login', App\Entities\Admin\Http\Controllers\LoginController::class)->name('admin.login');
Route::post('/admin/login', App\Entities\Admin\Http\Controllers\AuthController::class)->name('admin.auth');

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function () {

    Route::get('/', App\Http\Controllers\Main\IndexController::class)->name('main.index');

    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', App\Entities\Category\Http\Controllers\IndexController::class)->name('category.index');
        Route::get('/create', App\Entities\Category\Http\Controllers\CreateController::class)->name('category.create');
        Route::post('/', App\Entities\Category\Http\Controllers\StoreController::class)->name('category.store');
        Route::get('/{category}', App\Entities\Category\Http\Controllers\ShowController::class)->where('category', '[0-9]+')->name('category.show');
        Route::get('/{category}/edit', App\Entities\Category\Http\Controllers\EditController::class)->where('category', '[0-9]+')->name('category.edit');
        Route::patch('/{category}', App\Entities\Category\Http\Controllers\UpdateController::class)->where('category', '[0-9]+')->name('category.update');
        Route::delete('/{category}', App\Entities\Category\Http\Controllers\DeleteController::class)->where('category', '[0-9]+')->name('category.delete');
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::get('/', App\Entities\Tag\Http\Controllers\IndexController::class)->name('tag.index');
        Route::get('/create', App\Entities\Tag\Http\Controllers\CreateController::class)->name('tag.create');
        Route::post('/', App\Entities\Tag\Http\Controllers\StoreController::class)->name('tag.store');
        Route::get('/{tag}', App\Entities\Tag\Http\Controllers\ShowController::class)->where('tag', '[0-9]+')->name('tag.show');
        Route::get('/{tag}/edit', App\Entities\Tag\Http\Controllers\EditController::class)->where('tag', '[0-9]+')->name('tag.edit');
        Route::patch('/{tag}', App\Entities\Tag\Http\Controllers\UpdateController::class)->where('tag', '[0-9]+')->name('tag.update');
        Route::delete('/{tag}', App\Entities\Tag\Http\Controllers\DeleteController::class)->where('tag', '[0-9]+')->name('tag.delete');
    });

    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', App\Entities\Order\Http\Controllers\IndexController::class)->name('order.index');
        Route::get('/create', App\Entities\Order\Http\Controllers\CreateController::class)->name('order.create');
        Route::post('/', App\Entities\Order\Http\Controllers\StoreController::class)->name('order.store');
        Route::get('/{order}', App\Entities\Order\Http\Controllers\ShowController::class)->where('order', '[0-9]+')->name('order.show');
        Route::get('/{order}/edit', App\Entities\Order\Http\Controllers\EditController::class)->where('order', '[0-9]+')->name('order.edit');
        Route::patch('/{order}', App\Entities\Order\Http\Controllers\UpdateController::class)->where('order', '[0-9]+')->name('order.update');
        Route::delete('/{order}', App\Entities\Order\Http\Controllers\DeleteController::class)->where('order', '[0-9]+')->name('order.delete');
        Route::patch('/{order}/restore', App\Entities\Order\Http\Controllers\RestoreController::class)->where('order', '[0-9]+')->name('order.restore');

        Route::get('/export', App\Entities\Order\Http\Controllers\ExportController::class)->name('order.export');
        Route::get('/export-from-query', App\Entities\Order\Http\Controllers\ExportFromQueryController::class)->name('order.from.query.export');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', App\Entities\User\Http\Controllers\IndexController::class)->name('user.index');
        Route::get('/create', App\Entities\User\Http\Controllers\CreateController::class)->name('user.create');
        Route::post('/', App\Entities\User\Http\Controllers\StoreController::class)->name('user.store');
        Route::get('/{user}', App\Entities\User\Http\Controllers\ShowController::class)->where('user', '[0-9]+')->name('user.show');
        Route::get('/{user}/edit', App\Entities\User\Http\Controllers\EditController::class)->where('user', '[0-9]+')->name('user.edit');
        Route::patch('/{user}', App\Entities\User\Http\Controllers\UpdateController::class)->where('user', '[0-9]+')->name('user.update');
        Route::patch('/{user}/restore', App\Entities\User\Http\Controllers\RestoreController::class)->where('user', '[0-9]+')->name('user.restore');
        Route::delete('/{user}', App\Entities\User\Http\Controllers\DeleteController::class)->where('user', '[0-9]+')->name('user.delete');
    });

    Route::group(['prefix' => 'products'], function () {
        Route::get('/', App\Entities\Product\Http\Controllers\IndexController::class)->name('product.index');
        Route::get('/create', App\Entities\Product\Http\Controllers\CreateController::class)->name('product.create');
        Route::post('/', App\Entities\Product\Http\Controllers\StoreController::class)->name('product.store');
        Route::get('/{product}', App\Entities\Product\Http\Controllers\ShowController::class)->where('product', '[0-9]+')->name('product.show');
        Route::get('/{product}/edit', App\Entities\Product\Http\Controllers\EditController::class)->where('product', '[0-9]+')->name('product.edit');
        Route::patch('/{product}', App\Entities\Product\Http\Controllers\UpdateController::class)->where('product', '[0-9]+')->name('product.update');
        Route::patch('/{product}/restore', App\Entities\Product\Http\Controllers\RestoreController::class)->where('product', '[0-9]+')->name('product.restore');
        Route::delete('/{product}', App\Entities\Product\Http\Controllers\DeleteController::class)->where('product', '[0-9]+')->name('product.delete');

        Route::get('/export', App\Entities\Product\Http\Controllers\ExportController::class)->name('product.export');
        Route::get('/export-from-query', App\Entities\Product\Http\Controllers\ExportFromQueryController::class)->name('product.from.query.export');

        Route::patch('/mass/publish', App\Entities\Product\Http\Controllers\MassPublishController::class)->where('product', '[0-9]+')->name('product.mass.publish');
        Route::delete('/mass/delete', App\Entities\Product\Http\Controllers\MassDeleteController::class)->where('product', '[0-9]+')->name('product.mass.delete');

        Route::group(['prefix' => 'images/{product}'], function () {
            Route::patch('/{productImage}', App\Entities\Product\Http\Controllers\UpdateImageController::class)->where('product', '[0-9]+')->where('productImage', '[0-9]+')->name('product.image.update');
            Route::post('/', App\Entities\Product\Http\Controllers\StoreImageController::class)->where('product', '[0-9]+')->name('product.image.store');
        });
    });

    Route::group(['prefix' => 'reviews'], function () {
        Route::get('/', App\Entities\Review\Http\Controllers\IndexController::class)->name('review.index');
        Route::patch('/{review}/restore', App\Entities\Review\Http\Controllers\RestoreController::class)->where('review', '[0-9]+')->name('review.restore');
        Route::patch('/{review}/confirm', App\Entities\Review\Http\Controllers\ConfirmController::class)->where('review', '[0-9]+')->name('review.confirm');
        Route::delete('/{review}/delete', App\Entities\Review\Http\Controllers\DeleteController::class)->where('review', '[0-9]+')->name('review.delete');
        Route::get('/{review}', App\Entities\Review\Http\Controllers\ShowController::class)->where('review', '[0-9]+')->name('review.show');
    });
});

Auth::routes();

Route::get('{page}', \App\Http\Controllers\Client\IndexController::class)->where('page', '.*')->name('client');

