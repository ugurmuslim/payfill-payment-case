<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/payment', [\App\Http\Controllers\TransactionController::class, 'create'])->middleware('auth:sanctum');
