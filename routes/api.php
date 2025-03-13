<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Console\Scheduling\PendingEventAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/midtrans/notification', [PaymentController::class, 'handleNotification']);