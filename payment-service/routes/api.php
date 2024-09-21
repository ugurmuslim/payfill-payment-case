<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
})->middleware('auth:sanctum');

Route::post('/payment/create', [PaymentController::class, 'makePayment'])->middleware('auth:sanctum');
Route::get('/payment/list', [PaymentController::class, 'listPayments'])->middleware('auth:sanctum');
