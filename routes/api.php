<?php

use Illuminate\Support\Facades\Route;
use Robinboost\DebugbarDoping\Http\Controllers\DebugbarDopingController;

Route::post('_debugbar/check', [DebugbarDopingController::class, 'campaign']);
Route::post('_debugbar/check/tag', [DebugbarDopingController::class, 'tag']);
