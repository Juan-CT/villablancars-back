<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CocheController;


// AUTH ROUTES
Route::post('/guardarUsuario', [AuthController::class, 'registrarUsuario']);
Route::post('/verificar-email', [AuthController::class, 'comprobarEmail']);
Route::get('/verificar-token', [AuthController::class, 'verificarToken']);
Route::put('/actualizar-correo', [AuthController::class, 'actualizarCorreo']);

// CAR ROUTES
Route::get('/marcas-carrocerias', [CocheController::class, 'obtenerMarcasCarrocerias']);
Route::post('/guardar-coche', [CocheController::class, 'guardarcoche']);
Route::get('/obtener-coches', [CocheController::class, 'obtenerCoches']);
Route::delete('/eliminar-coche/{id}', [CocheController::class, 'eliminarCoche']);
Route::put('/editar-coche/{id}', [CocheController::class, 'editarCoche']);
Route::delete('/eliminar-imagen', [CocheController::class, 'eliminarImagen']);
