<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipateController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::apiResource('events', EventController::class);
Route::apiResource('participates', ParticipateController::class);
Route::apiResource('agencies', AgencyController::class);
Route::apiResource('users', UserController::class);