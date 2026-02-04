<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','admin'])->group(function() {
 Route::get('/user',[AuthController::class, 'getUser']);
 Route::post('/logout', [AuthController::class, 'logout']);
 Route::apiResource('/product',ProductController::class);
});

Route::post('/login',[AuthController::class, 'login']);