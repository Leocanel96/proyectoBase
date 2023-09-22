<?php

namespace App\Http\Controllers;

use App\Models\rol;
use Illuminate\Http\Request;

class rolesController extends Controller
{
    //
    public function obtenerRolesCreados()
    {
        $obtenerRoles = rol::select()
            ->where('id_rol', '!=', 1)
            ->paginate(5);
        $obtenerRoles->getCollection()->map(function ($obtenerRoles) {
            if ($obtenerRoles['estado_rol'] == 1) {
                $obtenerRoles['estado_rol'] = 'Activo';
                $obtenerRoles['id_estado_rol'] = 1;
            } else {
                $obtenerRoles['estado_rol'] = 'Inactivo';
                $obtenerRoles['id_estado_rol'] = 0;
            }
            return $obtenerRoles;
        });

        $obtenerRoles = json_encode($obtenerRoles);
        $obtenerRoles = json_decode($obtenerRoles);

        return response()->json([
            'roles' => $obtenerRoles
        ], 200);
    }

    public function guardarRol(Request $request)
    {
        $nombre = $request->datos['nombreRol'];
        //guardar Rol
        $guardarRol = new rol();
        $guardarRol->nombre_rol = $nombre;
        $guardarRol->estado_rol = 1;
        if ($guardarRol->save()) {
            return response()->json([
                'title' => 'Listo!',
                'message' => 'Rol creado correctamente.',
            ], 200);
        }

        return response()->json([
            'title' => 'Atención',
            'message' => 'Ha ocurrido un error al almacenar la información, por favor intente de nuevo.',
        ], 500);

    }

    public function guardarRolEditado(Request $request)
    {
        $idRol = $request->datos['id_rol'];
        $nombreRol = $request->datos['nombre_rol'];

        //editar rol
        $editarRol = rol::find($idRol);
        $editarRol->nombre_rol = $nombreRol;
        if ($editarRol->save()) {
            return response()->json([
                'title' => 'Listo!',
                'message' => 'Rol editado correctamente.',
            ], 200);
        }

        return response()->json([
            'title' => 'Atención',
            'message' => 'Ha ocurrido un error al editar el rol.',
        ], 403);
    }

    public function desactivarRol(Request $request)
    {
        $idRol = $request->datos['idRol'];
        $desactivarRol = rol::find($idRol);
        $desactivarRol->estado_rol = 0;

        if ($desactivarRol->save()) {
            return response()->json([
                'title' => 'Listo!',
                'message' => 'Rol desactivado con éxito',
            ], 200);
        }

        return response()->json([
            'title' => 'Atención',
            'message' => 'Ha ocurrido un error al desactivar el rol, por favor intente de nuevo',
        ], 403);
    }

    public function activarRol(Request $request)
    {
        $idRol = $request->datos['id_rol'];
        $activarRol = rol::find($idRol);
        $activarRol->estado_rol = 1;

        if ($activarRol->save()) {
            return response()->json([
                'title' => 'Listo!',
                'message' => 'Rol activado con éxito',
            ], 200);
        }

        return response()->json([
            'title' => 'Atención',
            'message' => 'Ha ocurrido un error al activar el rol, por favor intente de nuevo',
        ], 403);
    }


}