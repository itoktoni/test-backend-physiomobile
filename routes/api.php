<?php

use App\Http\Controllers\PatientController;
use App\Http\Middleware\ApiAccessKeyMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::middleware([ApiAccessKeyMiddleware::class])->group(function () {
        Route::apiResource('patients', PatientController::class);
        // Add other protected routes here
    });
});
