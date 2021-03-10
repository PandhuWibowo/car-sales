<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

Route::prefix('products')->group(function() {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'delete']);
});

Route::prefix('orders')->group(function() {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/buy', [OrderController::class, 'buy']);
});

Route::get('signout', [AuthController::class, 'signout'])->name('signout');
Route::get('signin', [AuthController::class, 'signin'])->name('signin');
Route::post('check', [AuthController::class, 'check'])->name('check');