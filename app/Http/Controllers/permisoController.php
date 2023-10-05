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


//        $cantidadValores = $obtenerPermisos . sizeof($obtenerPermisos);
        $obtenerPermisos = json_encode($obtenerPermisos);
        $obtenerPermisos = json_decode($obtenerPermisos);


//        for ($i = 1; $i <= $cantidadValores - 1; $i++) {
//            $obtenerPermisos->permisos_creados = $permisos = json_decode($obtenerPermisos->data[$i]->permisos_creados);
//        }


        return response()->json([
            'permisos' => $obtenerPermisos
        ], 200);
    }

    public function guardarPermiso(Request $request)
    {
        $nombrePermiso = $request->datos['nombrePermiso'];
        $descripcionPermiso = $request->datos['descripcionPermiso'];
        $tituloPermiso = $request->datos['tituloPermiso'];
        $rutaPermiso = $request->datos['rutaPermiso'];
        $iconoPermiso = $request->datos['iconoPermiso'];

        $guardarPermiso = new permiso();
        $guardarPermiso->nombre = $nombrePermiso;
        $guardarPermiso->descripcion = $descripcionPermiso;
        $guardarPermiso->titulo = $tituloPermiso;
        $guardarPermiso->path = $rutaPermiso;
        $guardarPermiso->icono = $iconoPermiso;
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
        $nombrePermiso = $request->datos['nombre'];
        $descripcionPermiso = $request->datos['descripcion'];
        $titulo = $request->datos['titulo'];
        $ruta = $request->datos['path'];
        $icono = $request->datos['icono'];

        $editarPermiso = permiso::find($idPermiso);
        $editarPermiso->nombre = $nombrePermiso;
        $editarPermiso->descripcion = $descripcionPermiso;
        $editarPermiso->titulo = $titulo;
        $editarPermiso->path = $ruta;
        $editarPermiso->icono = $icono;
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

    public function guardarPermisosAgregados(Request $request)
    {
        $permisosAdministrador = $request->datos['administrador'];
        $permisosSistema = $request->datos['sistema'];
        $permisosPersonal = $request->datos['personal'];

        $permisos = $request->datos;
        $permisos = json_encode($permisos);

        $id = $request->datos['idEditar'];
        $guardarPermisos = permiso::find($id);
        $guardarPermisos->permisos_creados = $permisos;
        if ($guardarPermisos->save()) {
            return response()->json([
                'title'   => 'Listo!',
                'message' => 'Permisos agregados correctamente.',
            ], 200);
        } else {
            return response()->json([
                'title'   => 'Atención!',
                'message' => 'Ha ocurrido un error, por favor verifique.'
            ], 403);
        }
    }
}
