<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\TransactionController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/item', [ItemController::class, 'index'])->name('item');
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction');

