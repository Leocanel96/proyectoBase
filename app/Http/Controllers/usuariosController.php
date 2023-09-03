<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\Models\tipo_platillo;
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

    public function rolUsuarios(Request $request)
    {
        $busquedaRol = rol::selectRaw('id_rol,nombre_rol')
            ->get();

        if ($busquedaRol->isEmpty()) {
            return;
        }

        $busquedaRol->toArray();
        return response()->json([
            'rolesEncontrados' => $busquedaRol
        ], 200);
    }

    public function guardarUsuario(Request $request)
    {
        $usuarioEnviado = $request->datos;
        $nombres = $usuarioEnviado['nombres'];
        $apellidos = $usuarioEnviado['apellidos'];
        $correo = $usuarioEnviado['correo'];
        $idRol = $usuarioEnviado['rol']['id_rol'];
        $nombreRol = $usuarioEnviado['rol']['nombre_rol'];

        //guardar usuario
        $guardarUsuario = new usuario();
        $guardarUsuario->nombres = $nombres;
        $guardarUsuario->apellidos = $apellidos;
        $guardarUsuario->correo = $correo;
        $guardarUsuario->id_rol = $idRol;
        $guardarUsuario->fecha_creacion = date('Y-m-d H:i:s');
        if ($guardarUsuario->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Usuario creado correctamente.',
            ], 200);
        }

        return response()->json([
            'title'   => 'Atención',
            'message' => 'Ha ocurrido un error al almacenar la información, por favor intente de nuevo.',
        ], 500);

    }

}
