<?php

use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PromoController;
use App\Http\Controllers\API\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'v1'
], function () {
    Route::get('faq', [FAQController::class, 'index']);
    Route::get('promo', [PromoController::class, 'index']);
    Route::get('menu', [MenuController::class, 'index']);

    Route::group([
        'prefix' => 'user',
    ], function () {
        Route::post('check-phone-number', [UserController::class, 'index']);
        Route::post('add-phone-number', [UserController::class, 'store']);
    });

    Route::group([
        'prefix' => 'order'
    ], function () {
        Route::post('list-order', [OrderController::class, 'index']);
        Route::post('store-order', [OrderController::class, 'store']);
        Route::post('update-order', [OrderController::class, 'update']);
        Route::post('delete', [OrderController::class, 'delete']);
    });
});
