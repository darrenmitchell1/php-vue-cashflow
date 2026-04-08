<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\StatementController;

Route::inertia('/', 'Cashflow')->name('home');


Route::get('/item-types', [ItemTypeController::class, 'index'])->name('item_types.index');
Route::get('/item-types/create', [ItemTypeController::class, 'create'])->name('item_types.create');
Route::post('/item-types', [ItemTypeController::class, 'store'])->name('item_types.store');
Route::get('/item-types/{itemType:uuid}', [ItemTypeController::class, 'show'])->name('item_types.show');
Route::get('/item-types/{itemType:uuid}/edit', [ItemTypeController::class, 'edit'])->name('item_types.edit');
Route::patch('/item-types/{itemType:uuid}', [ItemTypeController::class, 'update'])->name('item_types.update');
Route::delete('/item-types/{itemType:uuid}', [ItemTypeController::class, 'destroy'])->name('item_types.destroy');
Route::patch('/item-types/{itemType:uuid}/restore', [ItemTypeController::class, 'restore'])->name('item_types.restore')->withTrashed();


Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items', [ItemController::class, 'store'])->name('items.store');
Route::get('/items/{item:uuid}', [ItemController::class, 'show'])->name('items.show');
Route::get('/items/{item:uuid}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::patch('/items/{item:uuid}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{item:uuid}', [ItemController::class, 'destroy'])->name('items.destroy');


Route::get('/statement', [StatementController::class, 'index'])->name('statement.index');
Route::get('/statement/{period_from}/{period_from}', [StatementController::class, 'show'])->name('statement.show');
