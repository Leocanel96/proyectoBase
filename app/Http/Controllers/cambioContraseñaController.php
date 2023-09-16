<?php

namespace App\Http\Controllers;

use App\Models\usuario;
use Illuminate\Http\Request;

class cambioContraseñaController extends Controller
{
    //
    public function cambiarPassword(Request $request)
    {
        $passActual = $request->datos['actual'];
        $passNueva = $request->datos['nueva'];
        $passConfirmacion = $request->datos['confirmacion'];
        $idUsuario = $_SESSION['id_user'];

//        if ($passNueva !== $passConfirmacion) {
//            return response()->json([
//                'title'   => 'Atención!',
//                'message' => 'Contraseñas no coinciden'
//            ], 403);
//        }

        $validarPassActual = $this->validaPassActual($idUsuario);

        if ($validarPassActual == $passActual) {
            $cambiaPass = usuario::find($idUsuario);
            $cambiaPass->contraseña = $passNueva;
            if ($cambiaPass->save()) {
                return response()->json([
                    'title'   => 'Listo!',
                    'message' => 'Contraseña actualizada correctamente.',
                ], 200);
            }
        }

        return response()->json([
            'title'   => 'Atención',
            'message' => 'La contraseña actual no es correcta, por favor intente de nuevo.',
        ], 401);
    }

    public function validaPassActual($idUsuario)
    {
        $passActual = usuario::select()
            ->where('id_usuario', '=', $idUsuario)
            ->get();

        if (!$passActual->isEmpty()) {
            return $passActual[0]['contraseña'];
        }
        return false;
    }
}
