<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/createUser', [LoginController::class, 'createUser']);

Route::middleware(['validate.token'])->group(function () {
    Route::post('/generate-report', [ReportController::class, 'createReport']);
    Route::post('/list-reports', [ReportController::class, 'findAllReports']);
    Route::post('/get-report', [ReportController::class, 'findById']);
});

