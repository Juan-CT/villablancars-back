<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CocheController;

Route::post('/guardarUsuario', [AuthController::class, 'registrarUsuario']);
Route::post('/verificar-email', [AuthController::class, 'comprobarEmail']);
Route::get('/verificar-token', [AuthController::class, 'verificarToken']);

Route::get('/marcas-carrocerias', [CocheController::class, 'obtenerMarcasCarrocerias']);
Route::post('/guardar-coche', [CocheController::class, 'guardarcoche']);
