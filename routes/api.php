<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/forgot-password', [AuthController::class, 'sendResetOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
