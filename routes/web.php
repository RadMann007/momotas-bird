<?php

use App\Http\Controllers\CircuitController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DayCircuitController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/admin', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//circuit
Route::middleware('auth')->group(function () {
    Route::resource('circuits', CircuitController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('days', DayCircuitController::class);
});

Route::get('/contact', [ContactController::class, 'index']);

require __DIR__.'/auth.php';
