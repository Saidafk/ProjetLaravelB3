<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [StripeController::class, 'login']);

Route::middleware('api')->group(function () {
    Route::get('/films/{film}/locations', [FilmController::class, 'locations']);
});
