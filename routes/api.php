<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipateController;
use Illuminate\Support\Facades\Route;


Route::apiResource('events', EventController::class);
Route::apiResource('participates', ParticipateController::class);