<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Coche;

class GestorController extends Controller
{
    public function guardarCoche(Request $request)
    {
        $request->validate([
            'coche_id' => 'required|exists:coches,id',
        ]);

        $usuario = Usuario::where('idFirebase', $request->input('firebase_id'))->firstOrFail();

        $coche = Coche::findOrFail($request->input('coche_id'));

        if ($usuario->coches()->where('coche_id', $coche->id)->exists()) {
            return response()->json([
                'message' => 'El coche ya está guardado.',
            ], 400);
        }

        $usuario->coches()->attach($coche->id);

        return response()->json([
            'message' => 'Coche guardado exitosamente.',
            'coche' => $coche,
        ], 201);
    }

    public function obtenerCochesUsuario(Request $request)
    {
        $request->validate([
            'firebase_id' => 'required|exists:usuarios,idFirebase',
        ]);

        $usuario = Usuario::where('idFirebase', $request->input('firebase_id'))->firstOrFail();

        $cochesGuardados = $usuario->coches()->with('imagenes')->get();

        $cochesGuardados->each(function ($coche) {
            $coche->imagenes->each(function ($imagen) {
                $imagen->url = url($imagen->url);
            });
        });

        return response()->json([
            'coches' => $cochesGuardados,
        ], 200);
    }

    public function eliminarCocheUsuario(Request $request)
    {
        $request->validate([
            'firebase_id' => 'required|exists:usuarios,idFirebase',
            'coche_id' => 'required|exists:coches,id',
        ]);

        $usuario = Usuario::where('idFirebase', $request->input('firebase_id'))->firstOrFail();
        $coche = Coche::findOrFail($request->input('coche_id'));

        $usuario->coches()->detach($coche->id);

        return response()->noContent(200);
    }
}
