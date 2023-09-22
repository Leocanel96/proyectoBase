<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'user' => 'string|required',
            'pass' => 'string|required',
        ]);

        $password = $request->pass;
        $usuario = $request->user;

        $validarPass = usuario::selectRaw('id_usuario, nombres, apellidos, contraseña, estado_usuario')
            ->where('contraseña', '=', $password)
            ->where('correo', '=', $usuario)
            ->get();

        

        if (!$validarPass->isEmpty()) {
            
            session_start();
            if ($validarPass[0]['estado_usuario'] !== 1) {
                return response()->json([
                    'title'   => 'Atención!',
                    'message' => 'Usuario no se encuentra activo'
                ], 403);
            }
    
            $idUsuario = $validarPass[0]['id_usuario'];
            $nombres = $validarPass[0]['nombres'];
            $apellidos = $validarPass[0]['apellidos'];

            $_SESSION['id_user'] = $idUsuario;
            $_SESSION['nombres'] = $nombres;
            $_SESSION['apellidos'] = $apellidos;

            return response()->json([
                'title'     => 'Sesión iniciada',
                'message'   => 'Bienvenido',
                'nombres'   => $nombres,
                'apellidos' => $apellidos
            ], 200);
        }
        return response()->json([
            'title'   => 'Atención!',
            'message' => 'Credenciales incorrectas.'
        ], 403);
    }
}
