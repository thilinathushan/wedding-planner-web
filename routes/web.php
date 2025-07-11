<?php

use App\Http\Controllers\Couple\CoupleOnboardingController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Middleware\EnsureCoupleIsSetUp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('dashboard');
})->middleware(['auth', 'verified', EnsureCoupleIsSetUp::class]);

Route::controller(CoupleOnboardingController::class)->group(function () {
    Route::get('/onboarding/setup', 'create')->name('onboarding.create');
    Route::post('/onboarding/setup', 'store')->name('onboarding.store');
})->middleware('auth');

Route::get('/invitation/accept/', function (Request $request) {
    dd($request);
})->name('invitations.accept');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
