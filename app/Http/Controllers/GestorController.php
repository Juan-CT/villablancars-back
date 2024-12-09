<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Usuario;
use App\Models\Coche;
use App\Models\Cita;

use App\Mail\CitaGenerada;
use App\Mail\CitaEstadoActualizado;
use App\Mail\CitaEliminada;
use App\Mail\FormularioVentaAdminMail;
use App\Mail\FormularioVentaUsuarioMail;
use App\Mail\FormularioContactoMail;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GestorController extends Controller
{

    public function guardarCocheUsuario(Request $request)
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

    public function obtenerHorasCitasDia(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date_format:Y-m-d'
        ]);

        $fecha = $request->input('fecha');

        $citas = Cita::where('fecha', $fecha)->get();

        $horasOcupadas = $citas->pluck('hora');

        return response()->json([
            'horas_ocupadas' => $horasOcupadas
        ], 200);
    }

    public function obtenerUsuarios()
    {
        $usuarios = Usuario::all();

        return response()->json([
            'usuarios' => $usuarios
        ], 200);
    }

    public function obtenerCitas()
    {
        $citas = Cita::with(['usuario', 'coche'])->get();

        return response()->json([
            'citas' => $citas
        ], 200);
    }

    public function obtenerCitasUsuario(Request $request)
    {
        $request->validate([
            'idFirebase' => 'required|string',
        ]);

        $idFirebase = $request->input('idFirebase');
        $usuario = Usuario::where('idFirebase', $idFirebase)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $citas = Cita::where('usuario_id', $usuario->id)
            ->with(['coche.imagenes'])
            ->orderBy('fecha', 'asc')
            ->get();

        $citas->each(function ($cita) {
            $cita->coche->imagenes->each(function ($imagen) {
                $imagen->url = url($imagen->url);
            });
        });

        return response()->json(['citas' => $citas], 200);
    }

    public function crearCita(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|exists:usuarios,idFirebase',
            'coche_id' => 'required|exists:coches,id',
            'fecha' => 'required|date_format:Y-m-d',
            'hora' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $usuario = Usuario::where('idFirebase', $request->usuario)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $citaId = $request->query('citaId');

        if ($citaId) {
            $cita = Cita::where('id', $citaId)->where('usuario_id', $usuario->id)->firstOrFail();
            $cita->update([
                'coche_id' => $request->input('coche_id'),
                'fecha' => $request->input('fecha'),
                'hora' => $request->input('hora'),
                'descripcion' => $request->input('descripcion'),
                'estado' => 'pendiente'
            ]);
            return response()->noContent(200);
        } else {
            $cita = new Cita();
            $cita->usuario_id = $usuario->id;
            $cita->coche_id = $request->coche_id;
            $cita->fecha = $request->fecha;
            $cita->hora = $request->hora;
            $cita->descripcion = $request->descripcion ?? '';
            $cita->estado = 'pendiente';

            $cita->save();

            $administradores = Usuario::where('rol', 'admin')->get();
            foreach ($administradores as $admin) {
                Mail::to($admin->email)->send(new CitaGenerada($cita));
            }

            return response()->noContent(200);
        }
    }

    public function eliminarCita(Request $request)
    {
        $request->validate([
            'idCita' => 'required|exists:citas,id'
        ]);

        $cita = Cita::where('id', $request->input('idCita'))->firstOrFail();

        $cita->delete();

        $administradores = Usuario::where('rol', 'admin')->get();
        foreach ($administradores as $admin) {
            Mail::to($admin->email)->send(new CitaEliminada($cita));
        }

        return response()->noContent(200);
    }

    public function actualizarEstadoCita(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:confirmada,cancelada,completada'
        ]);

        $cita = Cita::with('usuario')->findOrFail($id);
        $nuevoEstado = $request->input('estado');

        $cita->estado = $nuevoEstado;
        $cita->save();

        if (in_array($nuevoEstado, ['confirmada', 'cancelada'])) {
            Mail::to($cita->usuario->email)->send(new CitaEstadoActualizado($cita, $nuevoEstado));
        }

        return response()->noContent(200);
    }

    public function procesarFormularioContacto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'mensaje' => 'required|string|max:2000'
        ]);

        $administradores = Usuario::where('rol', 'admin')->get();
        foreach ($administradores as $admin) {
            Mail::to($admin->email)->send(new FormularioContactoMail($request));
        }

        return response()->noContent(200);
    }

    public function procesarFormularioVenta(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'anio' => 'required|integer|between:2000,' . date('Y'),
        ]);

        $numeroDeImagenes = 0;
        $imagenRutas = [];

        if ($request->hasFile('imagenes')) {
            $imagenes = $request->file('imagenes');
            $numeroDeImagenes = count($imagenes);

            foreach ($imagenes as $imagen) {
                $url = $imagen->store('imagenes', 'public');
                $imagenRutas[] = storage_path('app/public/' . $url);
            }
        }

        $administradores = Usuario::where('rol', 'admin')->get();
        foreach ($administradores as $admin) {
            Mail::to($admin->email)->send(new FormularioVentaAdminMail($request, $imagenRutas));
        }

        Mail::to($request->email)->send(new FormularioVentaUsuarioMail($request, $numeroDeImagenes));

        foreach ($imagenRutas as $path) {
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return response()->noContent(200);
    }
}
