<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgencyController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AgencyController::class, 'dashboard'])->name('agency.dashboard');
});