<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TableAvailabilityController;

Route::get('/tables/availability', [TableAvailabilityController::class, 'index']);