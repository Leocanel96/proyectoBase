<?php

namespace App\Http\Controllers;

use App\Models\permiso;
use App\Models\permisos_rol;
use App\Models\rol;
use Illuminate\Http\Request;

class asignacion extends Controller
{
    //
    public function obtenerPermisosAsignados()
    {
        $obtenerPermisos = permisos_rol::selectRaw('permisos_rol.id_permiso_rol, permisos_rol.fecha_creacion, rol.id_rol, rol.nombre_rol, rol.icono, permiso.id_permiso, permiso.nombre, permiso.descripcion, permiso.titulo, permiso.path, permiso.icono')
            ->join('rol', 'rol.id_rol', '=', 'permisos_rol.id_rol')
            ->join('permiso', 'permiso.id_permiso', '=', 'permisos_rol.id_permiso')
            ->paginate(5);


//        $cantidadValores = $obtenerPermisos . sizeof($obtenerPermisos);
        $obtenerPermisos = json_encode($obtenerPermisos);
        $obtenerPermisos = json_decode($obtenerPermisos);


//        for ($i = 1; $i <= $cantidadValores - 1; $i++) {
//            $obtenerPermisos->permisos_creados = $permisos = json_decode($obtenerPermisos->data[$i]->permisos_creados);
//        }

        return response()->json([
            'permisosAsignacion' => $obtenerPermisos
        ], 200);
    }

    public function obtenerRoles(Request $request)
    {
        $busquedaRoles = rol::selectRaw('id_rol, nombre_rol, icono')
            ->get();

        if ($busquedaRoles->isEmpty()) {
            return;
        }

        $busquedaRoles->toArray();
        $busquedaPermisos = $this->obtenerPermisos();
        $enviar = [
            'roles'    => $busquedaRoles,
            'permisos' => $busquedaPermisos
        ];


        return response()->json([
            'respuesta' => $enviar
        ], 200);
    }

    public function obtenerPermisos()
    {
        $buscarPermisos = permiso::selectRaw('id_permiso, nombre, descripcion, titulo, path, icono')
            ->get();
        $buscarPermisos->toArray();
        return $buscarPermisos;
    }

    public function guardarAsignacion(Request $request)
    {

        $rol = $request->datos['rol']['id_rol'];
        $permiso = $request->datos['permiso']['id_permiso'];


        $guardarAsignacion = new permisos_rol();
        $guardarAsignacion->id_permiso = $permiso;
        $guardarAsignacion->id_rol = $rol;
        $guardarAsignacion->fecha_creacion = date('Y-m-d H:i:s');
        if ($guardarAsignacion->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Asignación almacenada correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error'
            ], 403);
        }
    }

    public function guardarAsignacionEditada(Request $request)
    {
        $idPermisoRol = $request->datos['id_permiso_rol'];
        $idRol = $request->datos['nombre_rol']['id_rol'];
        $idPermiso = $request->datos['nombre']['id_permiso'];

        $editarAsignacion = permisos_rol::find($idPermisoRol);
        $editarAsignacion->id_permiso = $idPermiso;
        $editarAsignacion->id_rol = $idRol;
        if ($editarAsignacion->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Asignación editada correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error'
            ], 403);
        }
    }

    public function eliminarAsignacion(Request $request)
    {
        $idAsignacionEliminar = $request->datos;
        $asignacionEliminar = permisos_rol::where('id_permiso_rol', '=', $idAsignacionEliminar)
            ->delete();

        if ($asignacionEliminar === 1) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Asignación eliminada correctamente.',
            ], 200);
        }

        return response()->json([
            'title'   => 'Atención!',
            'message' => 'Ha ocurrido un error al eliminar la asignación.'
        ], 403);
    }
}
