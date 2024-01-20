<?php

use App\Http\Controllers\RecomendationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/saving-recomendation-data', [RecomendationController::class, 'index']);
Route::get('/cek', function () {
    return response()->json('cek');
});
