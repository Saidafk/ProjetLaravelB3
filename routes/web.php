<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/films', [FilmController::class, 'index'])->name('film.index');

    Route::get('/locations', [LocationController::class, 'index'])->name('location.index');
    Route::get('/locations/create', [LocationController::class, 'create'])->name('location.create');
    Route::post('/locations', [LocationController::class, 'store'])->name('location.store');
    Route::post('/locations/{location}/upvote', [LocationController::class, 'upvote'])->name('location.upvote');
    Route::get('/locations/{location}/edit', [LocationController::class, 'edit'])->name('location.edit');
    Route::put('/locations/{location}', [LocationController::class, 'update'])->name('location.update');
    Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->name('location.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/stripe', [StripeController::class, 'index'])->name('stripe.index');
});

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/films/create', [FilmController::class, 'create'])->name('film.create');
    Route::post('/films', [FilmController::class, 'store'])->name('film.store');
    Route::get('/films/{film}/edit', [FilmController::class, 'edit'])->name('film.edit');
    Route::put('/films/{film}', [FilmController::class, 'update'])->name('film.update');
    Route::delete('/films/{film}', [FilmController::class, 'destroy'])->name('film.destroy');
});

require __DIR__.'/auth.php';
