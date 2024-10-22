<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/guardarUsuario', [AuthController::class, 'registrarUsuario']);
Route::post('/verificar-email', [AuthController::class, 'comprobarEmail']);
Route::get('/verificar-token', [AuthController::class, 'verificarToken']);
