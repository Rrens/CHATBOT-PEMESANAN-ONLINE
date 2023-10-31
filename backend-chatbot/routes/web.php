<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'faq');
// Route::redirect('/', 'faq');

Route::group([
    'prefix' => 'user',
],  function () {
    Route::get('', [UserController::class, 'index'])->name('user.index');
    Route::post('/change-status-user', [UserController::class, 'change_status_user'])->name('user.change_status_user');
    Route::post('/block_user', [UserController::class, 'block_user'])->name('user.block_user');
});

Route::group([
    'prefix' => 'faq',
], function () {
    Route::get('', [FaqController::class, 'index'])->name('faq.index');
    Route::post('', [FaqController::class, 'store'])->name('faq.store');
    Route::post('update', [FaqController::class, 'update'])->name('faq.update');
    Route::post('delete', [FaqController::class, 'delete'])->name('faq.delete');
});

Route::group([
    'prefix' => 'menu',
], function () {
    Route::get('', [MenuController::class, 'index'])->name('menu.index');
    Route::post('', [MenuController::class, 'store'])->name('menu.store');
    Route::post('update', [MenuController::class, 'update'])->name('menu.update');
    Route::post('delete', [MenuController::class, 'delete'])->name('menu.delete');
});

Route::group([
    'prefix' => 'promo'
], function () {
    Route::get('', [PromoController::class, 'index'])->name('promo.index');
    Route::post('', [PromoController::class, 'store'])->name('promo.store');
    Route::post('update', [PromoController::class, 'update'])->name('promo.update');
    Route::post('delete', [PromoController::class, 'delete'])->name('promo.delete');
});

Route::group([
    'prefix' => 'order',
], function () {
    Route::get('', [OrderController::class, 'index'])->name('order.index');
    Route::post('resi-order', [OrderController::class, 'resi_order'])->name('order.resi');
    Route::get('tracking/{id}', [OrderController::class, 'tracking'])->name('order.tracking');
});
