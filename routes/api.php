<?php


use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RegistroVentasController;
use App\Http\Controllers\UserController;

// Ruta para iniciar sesión
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/search/{field}/{query}', [UserController::class, 'search']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::get('/inventario/view', [InventoryController::class, 'index']);
    Route::put('/inventario/update', [InventoryController::class, 'update']);
    Route::post('/inventario/create', [InventoryController::class, 'store']);
    Route::get('/inventario/search/{field}/{query}', [InventoryController::class, 'search']);
    Route::delete('/inventario/{id}', [InventoryController::class, 'destroy']);


    Route::get('/invoices', [RegistroVentasController::class, 'index']);
    Route::put('/invoices/{id}', [RegistroVentasController::class, 'update']);
    Route::post('/invoices', [RegistroVentasController::class, 'store']);
    Route::get('/invoices/search/{field}/{query}', [RegistroVentasController::class, 'search']);
    Route::delete('/invoices/{id}', [RegistroVentasController::class, 'destroy']);
});

