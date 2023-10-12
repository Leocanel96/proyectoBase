<?php

namespace App\Http\Controllers;

use App\Models\permisos_rol;
use App\Models\rol;
use Illuminate\Http\Request;

class rutasController extends Controller
{
    //
    public function obtenerRutas()
    {
        $obtenerRutas = permisos_rol::selectRaw('permisos_rol.id_permiso_rol, permisos_rol.fecha_creacion, rol.id_rol, rol.nombre_rol, rol.icono, permiso.id_permiso, permiso.nombre, permiso.descripcion, permiso.titulo, permiso.path, permiso.icono')
            ->join('rol', 'rol.id_rol', '=', 'permisos_rol.id_rol')
            ->join('permiso', 'permiso.id_permiso', '=', 'permisos_rol.id_permiso')
            ->get();

        $obtenerRolesAsignados = permisos_rol::selectRaw('permisos_rol.id_rol, rol.nombre_rol, rol.icono')
            ->join('rol', 'rol.id_rol', 'permisos_rol.id_rol')
            ->groupBy('permisos_rol.id_rol')
            ->get();

//        funcion map mas efectiva que el foreach solo para collections
        $obtenerRolesAsignados = $obtenerRolesAsignados->map(function ($obtenerRolesAsignados) {
            $permisos = $this->permisosAsignados($obtenerRolesAsignados->id_rol);

            $obtenerRolesAsignados->permisos = $permisos;
            return $obtenerRolesAsignados;
        });

        if ($obtenerRolesAsignados->isEmpty()) {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'No existen permisos asignados.'
            ], 403);
        }

        return response()->json([
            'rutas' => $obtenerRolesAsignados
        ], 200);
    }


    public function permisosAsignados($idRol)
    {
        $roles = permisos_rol::selectRaw('permisos_rol.id_permiso_rol, permisos_rol.fecha_creacion, rol.id_rol, rol.nombre_rol, rol.icono, permiso.id_permiso, permiso.nombre, permiso.descripcion, permiso.titulo, permiso.path, permiso.icono')
            ->join('rol', 'rol.id_rol', '=', 'permisos_rol.id_rol')
            ->join('permiso', 'permiso.id_permiso', '=', 'permisos_rol.id_permiso')
            ->where('permisos_rol.id_rol', '=', $idRol)
            ->get();
        return $roles;
    }
}
