<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserController;
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



Route::group([
    'prefix' => 'faq',
], function () {
    Route::get('', [FaqController::class, 'index'])->name('faq.index');
    Route::post('', [FaqController::class, 'store'])->name('faq.store');
    Route::post('update', [FaqController::class, 'update'])->name('faq.update');
    Route::post('delete', [FaqController::class, 'delete'])->name('faq.delete');
});

// Route::group([
//     'prefix' => 'promo'
// ], function() {
//     Route::get('')
// })
