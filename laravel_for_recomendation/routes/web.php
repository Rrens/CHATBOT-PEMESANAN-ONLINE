<?php

use App\Http\Controllers\RecomendationController;
use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return view('welcome');
});
