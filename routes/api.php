<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TableAvailabilityController;
use App\Http\Controllers\ReservationCRUDController;
use App\Http\Controllers\TableController;

Route::get('/tables/availability', [TableAvailabilityController::class, 'index']);
Route::delete('/tables/{id}', [TableController::class, 'destroy']);
Route::get('/tables-data', [TableController::class, 'tablesData']);
Route::post('/tables', [TableController::class, 'store']);
Route::put('/tables/{id}', [TableController::class, 'update']);
Route::get('/tables/{id}', [TableController::class, 'edit'])->name('tables.edit');

