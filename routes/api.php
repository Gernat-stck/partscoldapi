<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\RegistroVentasController;


// Ruta para iniciar sesión
Route::middleware('auth.session')->post('/login', [LoginController::class, 'authenticate']);
Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']);

//Rutas de la api
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UsersController::class, 'index']);
    Route::put('/users/{id}', [UsersController::class, 'update']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::delete('/users/{id}', [UsersController::class, 'destroy']);

    Route::get('/inventario', [InventariosController::class, 'index']);
    Route::put('/inventario/{id}', [InventariosController::class, 'update']);
    Route::post('/inventario/create', [InventariosController::class, 'store']);
    Route::get('/inventario/search', [InventariosController::class, 'search']);
    Route::delete('/inventario/{id}', [InventariosController::class, 'destroy']);


    Route::get('/invoices', [RegistroVentasController::class, 'index']);
    Route::put('/invoices/{id}', [RegistroVentasController::class, 'update']);
    Route::post('/invoices', [RegistroVentasController::class, 'store']);
    Route::get('/invoices/search', [RegistroVentasController::class, 'search']);
    Route::delete('/invoices/{id}', [RegistroVentasController::class, 'destroy']);

    Route::post('/generate-invoice', [PdfController::class, 'generateInvoice']);

});
