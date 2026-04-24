<?php

use App\Http\Controllers\LocationController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [StripeController::class, 'login']);

Route::get('/locations', [LocationController::class, 'indexApi']);
