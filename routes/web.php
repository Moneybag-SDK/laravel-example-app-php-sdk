<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Payment callbacks
Route::post('/payment/callback', [CheckoutController::class, 'paymentCallback'])->name('payment.callback');
Route::get('/payment/success/{order}', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel/{order}', [CheckoutController::class, 'paymentCancel'])->name('payment.cancel');

// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

// Moneybag Transactions
use App\Http\Controllers\MoneybagTransactionController;
Route::get('/moneybag/transactions', [MoneybagTransactionController::class, 'index'])->name('moneybag.transactions');
Route::get('/moneybag/transactions/{transaction}', [MoneybagTransactionController::class, 'show'])->name('moneybag.show');
