<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CarritoComprasController; // Importación añadida
use App\Http\Controllers\AuthController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



//---------------------------------------------//
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('carrito', CarritoController::class);
    Route::post('InfoProductosCarrito', [CarritoController::class, 'GetDatos']);
    Route::post('InfoProductosVenta', [CarritoController::class, 'GetDatos']);
    Route::apiResource('CarritoCompras', CarritoComprasController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
});