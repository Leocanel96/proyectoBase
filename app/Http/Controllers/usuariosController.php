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
        //obtener todos los usuarios sin excepcion. Los usuario inactivos aparecen al final de la lista
        $obtenerUsuarios = usuario::selectRaw('usuario.id_usuario, usuario.nombres, usuario.apellidos, usuario.estado_usuario, usuario.correo, usuario.id_rol, rol.id_rol, rol.nombre_rol')
            ->join('rol', 'rol.id_rol', '=', 'usuario.id_rol')
            ->orderBy('usuario.id_usuario', 'asc')
            ->orderBy('usuario.estado_usuario', 'desc')
            ->paginate(5);


        $obtenerUsuarios->getCollection()->map(function ($obtenerUsuarios) {
            if ($obtenerUsuarios['estado_usuario'] == 1) {
                $obtenerUsuarios['estado_usuario'] = 'Activo';
                $obtenerUsuarios['id_estado_usuario'] = 1;
            } else {
                $obtenerUsuarios['estado_usuario'] = 'Inactivo';
                $obtenerUsuarios['id_estado_usuario'] = 0;
            }
            return $obtenerUsuarios;
        });


        //funcion map mas efectiva que el foreach solo para collections que a cada objeto le agrega el estado del documento si este registro no tiene fecha de egreso
//        $obtenerUsuarios = $obtenerUsuarios->map(function ($obtenerUsuarios) {
//            if ($obtenerUsuarios['estado_usuario'] == 1) {
//                $obtenerUsuarios['estado_usuario'] = 'Activo';
//                $obtenerUsuarios['id_estado_usuario'] = 1;
//            } else {
//                $obtenerUsuarios['estado_usuario'] = 'Inactivo';
//                $obtenerUsuarios['id_estado_usuario'] = 0;
//            }
//            return $obtenerUsuarios;
//        });

        $obtenerUsuarios = json_encode($obtenerUsuarios);
        $obtenerUsuarios = json_decode($obtenerUsuarios);


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
        $contraseña = $usuarioEnviado['contraseña'];
        $idRol = $usuarioEnviado['rol']['id_rol'];
        $nombreRol = $usuarioEnviado['rol']['nombre_rol'];
        //guardar usuario
        $guardarUsuario = new usuario();
        $guardarUsuario->nombres = $nombres;
        $guardarUsuario->apellidos = $apellidos;
        $guardarUsuario->correo = $correo;
        $guardarUsuario->contraseña = $contraseña;
        $guardarUsuario->estado_usuario = 1;
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

    public function guardarUsuarioEditado(Request $request)
    {
        $idUsuario = $request->datos['id_usuario'];
        $nombres = $request->datos['nombres'];
        $apellidos = $request->datos['apellidos'];
        $correo = $request->datos['correo'];
        $idRol = $request->datos['nombre_rol']['id_rol'];

        //editar usuario
        $editarUsuario = usuario::find($idUsuario);
        $editarUsuario->nombres = $nombres;
        $editarUsuario->apellidos = $apellidos;
        $editarUsuario->correo = $correo;
        $editarUsuario->id_rol = $idRol;
        if ($editarUsuario->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Usuario editado correctamente.',
            ], 200);
        }

        return response()->json([
            'title'   => 'Atención',
            'message' => 'Ha ocurrido un error al editar el usuario.',
        ], 403);

    }

    public function desactivarUsuario(Request $request)
    {
        $idUsuario = $request->datos['idUsuario'];
        $desactivarUsuario = usuario::find($idUsuario);
        $desactivarUsuario->estado_usuario = 0;

        if ($desactivarUsuario->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Usuario desactivado con éxito',
            ], 200);
        }

        return response()->json([
            'title'   => 'Atención',
            'message' => 'Ha ocurrido un error al desactivar el usaurio, por favor intente de nuevo',
        ], 403);
    }

    public function activarUsuario(Request $request)
    {
        $idUsuario = $request->datos['id_usuario'];
        $activarUsuario = usuario::find($idUsuario);
        $activarUsuario->estado_usuario = 1;

        if ($activarUsuario->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Usuario activado con éxito',
            ], 200);
        }

        return response()->json([
            'title'   => 'Atención',
            'message' => 'Ha ocurrido un error al activar el usaurio, por favor intente de nuevo',
        ], 403);
    }

}
