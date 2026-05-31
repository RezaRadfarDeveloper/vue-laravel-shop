<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class,'index'])->name('product.index');
Route::get('/product/{product}', [ProductController::class,'view'])->name('product.view');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//  TODO add middleware commented to the routes below
// Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/{order}', [OrderController::class, 'view'])->name('order.view');
    Route::post('/cart/checkout',[CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/{order}',[CheckoutController::class, 'checkoutSingleOrder'])->name('cart.checkout-single-order');
    Route::get('/checkout/success',[CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure',[CheckoutController::class, 'failure'])->name('checkout.failure');
// });

Route::get('/add-to-cart/{id}', [CartController::class,'addToCart'])->name('add-to-cart');
Route::get('/remove-from-cart/{id}', [CartController::class,'removeFromCart'])->name('remove-from-cart');
Route::get('/remove-item-from-cart/{id}', [CartController::class,'removeItemFromCart'])->name('remove-item-from-cart');
Route::get('/cart-details', [CartController::class,'showCart'])->name('cart-details');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
