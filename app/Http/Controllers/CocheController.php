<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Carroceria;
use Illuminate\Http\Request;
use App\Models\Coche;
use Illuminate\Support\Facades\Log;

class CocheController extends Controller
{

    public function obtenerMarcasCarrocerias()
    {
        $marcas = Marca::all();
        $carrocerias = Carroceria::all();

        return response()->json([
            'marcas' => $marcas,
            'carrocerias' => $carrocerias,
        ]);
    }

    public function guardarCoche(Request $request)
    {
        // Validación de datos
        $datosValidados = $request->validate([
            'marca_id' => 'required|integer',
            'carroceria_id' => 'required|integer',
            'cambio_id' => 'required|integer',
            'modelo' => 'required|string|max:255',
            'anio' => 'required|integer|digits:4',
            'color' => 'required|string|max:50',
            'precio' => 'required|numeric',
            'kilometros' => 'required|numeric',
            'autonomia' => 'required|numeric',
            'potencia' => 'required|numeric',
            'descripcion' => 'required|string',
        ]);
        try {
            // Creación del coche a enviar a la bbdd
            $coche = new Coche();
            $coche->marca_id = $datosValidados['marca_id'];
            $coche->carroceria_id = $datosValidados['carroceria_id'];
            $coche->cambio_id = $datosValidados['cambio_id'];
            $coche->modelo = $datosValidados['modelo'];
            $coche->anio = $datosValidados['anio'];
            $coche->color = $datosValidados['color'];
            $coche->precio = $datosValidados['precio'];
            $coche->kilometros = $datosValidados['kilometros'];
            $coche->autonomia = $datosValidados['autonomia'];
            $coche->potencia = $datosValidados['potencia'];
            $coche->descripcion = $datosValidados['descripcion'];

            $coche->save();

            return response()->noContent(201);
        } catch (\Exception $e) {
            return response()->noContent(500);
        }
    }

    public function obtenerCoches()
    {
        try {
            $coches = Coche::all();
            return response()->json($coches, 200);
        } catch (\Exception $e) {
            Log::error('Error al intentar traer los coches de la BBDD' . $e->getMessage());
            return response()->json(['message' => 'Error al obtener los coches'], 500);
        }
    }

    public function eliminarCoche($id)
    {
        try {
            $coche = Coche::findOrFail($id);
            $coche->delete();
            return response()->noContent(200);
        } catch (\Exception $e) {
            return response()->noContent(500);
        }
    }
}
