<?php

use Illuminate\Support\Facades\Route;
use Robinboost\DebugbarDoping\Http\Controllers\DebugbarDopingController;

Route::post('api/_debugbar/check', [DebugbarDopingController::class, 'campaign'])->name('_debugbar.check');
Route::post('api/_debugbar/check/tag', [DebugbarDopingController::class, 'tag'])->name('_debugbar.check-tag');
Route::post('api/_debugbar/optimize', [DebugbarDopingController::class, 'optimize'])->name('_debugbar.optimize');
