<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
            'rol' => 'usuario'
        ]);
        // Se retorna la respuesta exitosa
        return response()->json([
            'message' => 'Usuario creado',
        ], 201);
    }

    public function comprobarEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario) {
            return response()->json(['exists' => true], 200);
        } else {
            return response()->json(['exists' => false], 200);
        }
    }

    public function verificarToken(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        try {
            // Decodifica el encabezado para obtener el 'kid'
            $tokenParts = explode('.', $token);
            $header = json_decode(base64_decode($tokenParts[0]), true);
            $kid = $header['kid'];

            // Recupera las claves públicas de Firebase
            $publicKeys = Cache::remember('firebase_public_keys', 60, function () {
                $client = new Client(['verify' => false]);

                $response = $client->get('https://www.googleapis.com/service_accounts/v1/metadata/x509/securetoken@system.gserviceaccount.com');

                if ($response->getStatusCode() === 200) {

                    return json_decode($response->getBody(), true);
                } else {
                    return [];
                }
            });

            // Verifica que el 'kid' esté en las claves públicas
            if (!isset($publicKeys[$kid])) {
                return response()->json(['error' => 'Clave pública no encontrada'], 401);
            }

            // Usa la clave pública correspondiente para verificar el token
            JWT::$leeway = 30;
            $decodedToken = JWT::decode($token, new Key($publicKeys[$kid], 'RS256'));

            if (!isset($decodedToken->user_id)) {
                return response()->json(['error' => 'user_id no válido en el token'], 401);
            }

            $userId = $decodedToken->user_id;
            $usuario = Usuario::where('idFirebase', $userId)->first();

            if ($usuario) {
                return response()->json(['rol' => $usuario->rol ?? 'usuario']);
            } else {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json(['error' => 'Token expirado', 'message' => $e->getMessage()], 401);
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return response()->json(['error' => 'Firma del token inválida', 'message' => $e->getMessage()], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Token no válido', 'message' => $e->getMessage()], 401);
        }
    }

    public function actualizarCorreo(Request $request)
    {
        Log::info('Datos recibidos para actualizar correo:', $request->all());
        $request->validate([
            'idFirebase' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        Log::info('Validación de datos exitosa.');
        $usuario = Usuario::where('idFirebase', $request->idFirebase)->first();

        if (!$usuario) {
            Log::warning('Usuario no encontrado para el idFirebase: ' . $request->idFirebase);
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->email = $request->email;
        $usuario->save();
        Log::info('Correo electrónico actualizado correctamente para el idFirebase: ' . $request->idFirebase);
        return response()->json(['message' => 'Correo electrónico actualizado correctamente'], 200);
    }
}
