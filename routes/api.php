<?php

use App\Http\Controllers\MovieController;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;

Route::apiResource('movie',MovieController::class);
Route::apiResource('Ratings',RatingController::class);