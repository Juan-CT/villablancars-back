<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function registrarUsuario(Request $request)
    {
        // Validación de los datos entrantes
        $request->validate([
            'idFirebase' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios'
        ]);
        // Creación del usuario
        $usuario = Usuario::create([
            'idFirebase' => $request->idFirebase,
            'nombre' => $request->nombre,
            'email' => $request->email,
        ]);
        // Se retorna la respuesta exitosa
        return response()->json([
            'message' => 'Usuario creado',
            'usuario' => $usuario
        ], 201);
    }


}
