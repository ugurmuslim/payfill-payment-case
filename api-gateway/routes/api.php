<?php

use App\Http\Controllers\ProxyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Proxy routes
Route::match(['get', 'post', 'put', 'delete'], '/{service}/{any}', [ProxyController::class, 'handleRequest'])
    ->where('any', '.*')->middleware('auth:sanctum');;
