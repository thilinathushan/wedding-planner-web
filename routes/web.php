<?php

use App\Http\Controllers\Couple\CoupleOnboardingController;
use App\Http\Middleware\EnsureCoupleIsSetUp;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified', EnsureCoupleIsSetUp::class])->name('dashboard');

Route::controller(CoupleOnboardingController::class)->group(function () {
    Route::get('/onboarding/setup', 'create')->name('onboarding.create');
    Route::post('/onboarding/setup', 'store')->name('onboarding.store');
})->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
