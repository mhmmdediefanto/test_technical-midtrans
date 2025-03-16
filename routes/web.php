<?php

use App\Http\Controllers\BokingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::group(['middleware' => 'web'], function () {
    Route::get('/bookings', [BokingController::class, 'index'])->name('booking');
    Route::post('/bookings', [BokingController::class, 'store'])->name('bookings.store');


    Route::get('/bookings/konfirmed_booking/{id}', [BokingController::class, 'konfirmasi_booking'])->name('konfirmasi_booking');

    Route::get('/bookings/history', [BokingController::class, 'history'])->name('history');
    Route::get('/transactions/history', [BokingController::class, 'history_transaksi'])->name('history_transaksi');
});
