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

Route::get('/agencies/{id}/events', [AgencyController::class, 'events']);

Route::get('/events/{id}/participants', [EventController::class, 'participants']);

Route::get('/users/{id}/events', [UserController::class, 'events']);

Route::get('/events/active', [EventController::class, 'activeEvents']);