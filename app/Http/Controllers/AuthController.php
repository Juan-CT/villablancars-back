<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        return response()->json(['message' => 'conectado'], 200);
    }
}
