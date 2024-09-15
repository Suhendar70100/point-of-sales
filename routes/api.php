<?php

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TransactionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/category', CategoryController::class);
Route::get('/category-data', [CategoryController::class, 'dataTable'])->name('category.dataTable');

Route::apiResource('/item', ItemController::class);
Route::get('/item-data', [ItemController::class, 'dataTable'])->name('item.dataTable');

Route::apiResource('/transaction', TransactionController::class);
Route::get('/transaction-data', [TransactionController::class, 'dataTable'])->name('transaction.dataTable');