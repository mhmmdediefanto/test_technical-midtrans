<?php

use App\Http\Controllers\BokingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/bookings', [BokingController::class, 'index'])->name('booking');
Route::post('/bookings', [BokingController::class, 'store'])->name('bookings.store');


