<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\Models\usuario;
use Illuminate\Http\Request;

class usuariosController extends Controller
{
    //
    public function obtenerUsuariosCreados()
    {
        $obtenerUsuarios = usuario::selectRaw('usuario.id_usuario, usuario.nombres, usuario.apellidos, usuario.correo, usuario.id_rol, rol.id_rol, rol.nombre_rol')
            ->join('rol', 'rol.id_rol', '=', 'usuario.id_rol')
            ->get();


        return response()->json([
            'usuarios' => $obtenerUsuarios
        ], 200);
    }


}
