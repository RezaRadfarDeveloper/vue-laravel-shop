<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum','admin'])->group(function() {
 Route::get('/user',[AuthController::class, 'getUser']);
 Route::post('/logout', [AuthController::class, 'logout']);
 Route::apiResource('products',ProductController::class);

 //Dashboard Routes
 Route::get('/dashboard/customers-count', [DashboardController::class, 'totalCustomers'])->name('customers-count');
 Route::get('/dashboard/products-count', [DashboardController::class, 'activeProducts'])->name('products-count');
 Route::get('/dashboard/orders-count', [DashboardController::class, 'paidOrders'])->name('orders-count');
 Route::get('/dashboard/income', [DashboardController::class, 'totalIncome'])->name('total-income');
 Route::get('/dashboard/orders-by-country', [DashboardController::class, 'ordersByCountry'])->name('orders-by-country');
 Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers'])->name('latest-customers');
 Route::get('/dashboard/latest-orders', [DashboardController::class, 'latestOrders'])->name('latest-orders');
});

Route::post('/login',[AuthController::class, 'login']);