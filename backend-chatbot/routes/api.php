<?php

use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\API\OrderController as APIORDERContoller;
use App\Http\Controllers\API\PromoController;
use App\Http\Controllers\API\RecomendationController;
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
        Route::post('status-user', [UserController::class, 'check_status']);
        Route::post('change-status-user', [UserController::class, 'change_status']);
    });

    Route::group([
        'prefix' => 'order'
    ], function () {
        Route::post('list-order', [APIORDERContoller::class, 'index']);
        Route::post('list-order-per-date', [APIORDERContoller::class, 'list_order_per_date']);
        Route::post('store-order', [APIORDERContoller::class, 'store']);
        Route::post('update-order', [APIORDERContoller::class, 'update']);
        Route::post('delete', [APIORDERContoller::class, 'delete']);
        Route::post('check-payment', [APIORDERContoller::class, 'checK_payment']);
        Route::post('checkout', [APIORDERContoller::class, 'checkout']);
        Route::post('check-order-status', [APIORDERContoller::class, 'check_order_status']);
        Route::post('tracking-order', [APIORDERContoller::class, 'tracking_order']);
    });
});

Route::get('sales-data', [RecomendationController::class, 'index']);
Route::get('get-data-recomendation', [RecomendationController::class, 'get_data']);

Route::get('sales', [RecomendationController::class, 'index2']);

Route::post('midtrans/callback', [MidtransController::class, 'callback']);
