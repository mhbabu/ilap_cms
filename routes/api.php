<?php

use Illuminate\Support\Facades\Route;

Route::get('api/profile', function () {
    return auth()->user();
})->middleware('auth:sanctum');

Route::get('api/dashboard/summary', \App\Http\Controllers\DashboardController::class . '@apiSummary')
    ->middleware('auth:sanctum');
Route::get('api/campus/{campus}/stats', \App\Http\Controllers\CampusController::class . '@apiStats')
    ->middleware('auth:sanctum');
