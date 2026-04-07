<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\StatementController;

Route::inertia('/', 'Cashflow')->name('home');


Route::get('/item-types', [ItemTypeController::class, 'index'])->name('item_types.index');
Route::get('/item-types/create', [ItemTypeController::class, 'create'])->name('item_types.create');
Route::post('/item-types', [ItemTypeController::class, 'store'])->name('item_types.store');
Route::get('/item-types/{item_type}', [ItemTypeController::class, 'show'])->name('item_types.show');
Route::get('/item-types/{item_type}/edit', [ItemTypeController::class, 'edit'])->name('item_types.edit');
Route::patch('/item-types/{item_type}', [ItemTypeController::class, 'update'])->name('item_types.update');
Route::delete('/item-types/{item_type}', [ItemTypeController::class, 'destroy'])->name('item_types.destroy');


Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::patch('/items/{item}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');


Route::get('/statement', [StatementController::class, 'index'])->name('statement.index');
Route::get('/statement/{period_from}/{period_from}', [StatementController::class, 'show'])->name('statement.show');
