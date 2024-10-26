<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Carroceria;
use Illuminate\Http\Request;

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
}
