<?php

use App\Http\Controllers\BirdController;
use App\Http\Controllers\CircuitController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DayCircuitController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ItineraireController;
use App\Http\Controllers\ProfileController;
use App\Models\Circuit;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'circuits' => Circuit::take(3)->get()
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

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/itineraires', [ItineraireController::class, 'index'])->name('itineraires.index');
Route::get('/itineraires/{id}', [ItineraireController::class, 'show'])->name('itineraires.show');

// Birds
Route::middleware('auth')->group(function () {
    Route::resource('birds', BirdController::class);
});

//Image Morph
Route::middleware('auth')->group(function () {
    Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
});

require __DIR__.'/auth.php';
