<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\MenuController;
use App\Http\Controllers\API\V1\MenuItemController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'menu', 'as' => 'menu.'], function() {
    Route::get('/', [MenuController::class, 'index'])->name('index');
    Route::post('/', [MenuController::class, 'store'])->name('store');
    Route::get('/{menu}', [MenuController::class, 'show'])->name('show');

    Route::group(['prefix' => 'item', 'as' => 'item.'], function() {
        Route::post('/', [MenuItemController::class, 'store'])->name('store');
        Route::match(['put', 'patch'], '/', [MenuItemController::class, 'update'])->name('update');
        Route::delete('/', [MenuItemController::class, 'delete'])->name('delete');
        Route::put('/order', [MenuItemController::class, 'order'])->name('order');
    });
});
