<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\RegistroVentasController;


// Ruta para iniciar sesión
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//Rutas de la api
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UsersController::class, 'index']);
    Route::put('/users/{id}', [UsersController::class, 'update']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::get('/users/search/{field}/{query}', [UsersController::class, 'search']);
    Route::delete('/users/{id}', [UsersController::class, 'destroy']);

    Route::get('/inventario/', [InventarioController::class, 'index']);
    Route::put('/inventario/{id}', [InventarioController::class, 'update']);
    Route::post('/inventario/create', [InventarioController::class, 'store']);
    Route::get('/inventario/search/{field}/{query}', [InventarioController::class, 'search']);
    Route::delete('/inventario/{id}', [InventarioController::class, 'destroy']);


    Route::get('/invoices', [RegistroVentasController::class, 'index']);
    Route::put('/invoices/{id}', [RegistroVentasController::class, 'update']);
    Route::post('/invoices', [RegistroVentasController::class, 'store']);
    Route::get('/invoices/search/{field}/{query}', [RegistroVentasController::class, 'search']);
    Route::delete('/invoices/{id}', [RegistroVentasController::class, 'destroy']);
});
