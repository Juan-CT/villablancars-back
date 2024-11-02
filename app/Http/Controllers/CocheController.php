<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Carroceria;
use Illuminate\Http\Request;
use App\Models\Coche;
use App\Models\Imagen;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        $datosValidados = $request->validate([
            'marca_id' => 'required|integer',
            'carroceria_id' => 'required|integer',
            'cambio_id' => 'required|integer',
            'modelo' => 'required|string|max:255',
            'anio' => 'required|integer|digits:4',
            'color' => 'required|string|max:50',
            'precio' => 'required|integer',
            'kilometros' => 'required|integer',
            'autonomia' => 'required|integer',
            'potencia' => 'required|integer',
            'descripcion' => 'required|string',
        ]);

        try {
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

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $imagen) {
                    try {
                        $url = $imagen->store('imagenes', 'public');
                        $fullUrl = Storage::url($url);
                        Imagen::create(['coche_id' => $coche->id, 'url' => $fullUrl]);
                    } catch (\Exception $e) {
                        Log::error('Error al guardar la imagen: ' . $e->getMessage());
                    }
                }
            }

            return response()->noContent(200);
        } catch (\Exception $e) {
            return response()->noContent(500);
        }
    }

    public function editarCoche(Request $request, $id)
    {
        Log::info('Imagenes existentes recibidas:', $request->input('imagenesExistentes', []));
        try {
            $datosValidados = $request->validate([
                'marca_id' => 'required|integer',
                'carroceria_id' => 'required|integer',
                'cambio_id' => 'required|integer',
                'modelo' => 'required|string|max:255',
                'anio' => 'required|integer|digits:4',
                'color' => 'required|string|max:50',
                'precio' => 'required|integer',
                'kilometros' => 'required|integer',
                'autonomia' => 'required|integer',
                'potencia' => 'required|integer',
                'descripcion' => 'required|string',
            ]);

            $coche = Coche::findOrFail($id);
            $coche->update($datosValidados);

            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $imagen) {
                    try {
                        $url = $imagen->store('imagenes', 'public');
                        $fullUrl = Storage::url($url);
                        Imagen::create(['coche_id' => $coche->id, 'url' => $fullUrl]);
                    } catch (\Exception $e) {
                        Log::error('Error al guardar la imagen: ' . $e->getMessage());
                    }
                }
            }

            return response()->noContent(200);
        } catch (\Exception $e) {
            Log::error('Error editando coche: ' . $e->getMessage());
            return response()->json(['message' => 'Error al editar el coche'], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->validator->errors()], 422);
        }
    }

    public function obtenerCoches()
    {
        try {
            $coches = Coche::with('imagenes')->get()->map(function ($coche) {
                // Cambia la URL de cada imagen a una URL completa
                $coche->imagenes->each(function ($imagen) {
                    // Asegúrate de que el campo 'nombre' sea el correcto para tu caso
                    $imagen->url = url($imagen->url); // Cambia 'ruta' por el campo correcto que almacena la ruta relativa
                });
                return $coche;
            });
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
            Imagen::where('coche_id', $coche->id)->delete();
            $coche->delete();
            return response()->noContent(200);
        } catch (\Exception $e) {
            return response()->noContent(500);
        }
    }

    public function eliminarImagen(Request $request)
    {
        $url = $request->input('url');
        $path = public_path($url);

        if (File::exists($path)) {
            File::delete($path);
            Imagen::where('url', $url)->delete();
            return response()->noContent(200);
        }
        return response()->noContent(500);
    }
}
