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

        $validarPass = usuario::selectRaw('id_usuario, nombres, contraseña')
            ->where('contraseña', '=', $password)
            ->where('correo', '=', $usuario)
            ->get();

        if (!$validarPass->isEmpty()) {
            session_start();
            $_SESSION['id_user'] = 1;
            return response()->json([
                'title'   => 'Hola!',
                'message' => 'Bienvenido'
            ], 200);
        }
        return response()->json([
            'title'   => 'Atención!',
            'message' => 'Credenciales incorrectas.'
        ], 403);

    }

    public function cerrarSesion()
    {

    }
}
