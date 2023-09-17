<?php

namespace App\Http\Controllers;

use App\Models\permiso;
use Illuminate\Http\Request;

class permisoController extends Controller
{
    public function obtenerPermisosCreados()
    {
        $obtenerPermisos = permiso::select()
            ->paginate(5);
//        $obtenerRoles->getCollection()->map(function ($obtenerRoles) {
//            if ($obtenerRoles['estado_rol'] == 1) {
//                $obtenerRoles['estado_rol'] = 'Activo';
//                $obtenerRoles['id_estado_rol'] = 1;
//            } else {
//                $obtenerRoles['estado_rol'] = 'Inactivo';
//                $obtenerRoles['id_estado_rol'] = 0;
//            }
//            return $obtenerRoles;
//        });

        $obtenerPermisos = json_encode($obtenerPermisos);
        $obtenerPermisos = json_decode($obtenerPermisos);

        return response()->json([
            'permisos' => $obtenerPermisos
        ], 200);
    }


    public function guardarPermiso(Request $request)
    {
        $nombrePermiso = $request->datos['nombrePermiso'];

        $guardarPermiso = new permiso();
        $guardarPermiso->nombre_permiso = $nombrePermiso;
        $guardarPermiso->fecha_creacion = date('Y-m-d H:i:s');
        if ($guardarPermiso->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Permiso almacenado correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error, por favor intente de nuevo.'
            ], 403);
        }
    }


    public function guardarPermisoEditado(Request $request)
    {
        $idPermiso = $request->datos['id_permiso'];
        $nombrePermiso = $request->datos['nombre_permiso'];

        $editarPermiso = permiso::find($idPermiso);
        $editarPermiso->nombre_permiso = $nombrePermiso;
        if ($editarPermiso->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Permiso editado correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error'
            ], 403);
        }
    }
}
