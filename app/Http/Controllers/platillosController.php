<?php

namespace App\Http\Controllers;

use App\Models\platillo;
use App\Models\promocion;
use App\Models\tipo_platillo;
use Illuminate\Http\Request;

class platillosController extends Controller
{
    public function obtenerPlatillosCreados()
    {
        $obtenerPlatillos = platillo::select()
            ->get();


        return response()->json([
            'platillos' => $obtenerPlatillos
        ], 200);
    }

    public function tipoPlatillos(Request $request)
    {
        $busquedaPlatillo = tipo_platillo::select('nombre')
            ->get();

        if ($busquedaPlatillo->isEmpty()) {
            return;
        }

        $busquedaPlatillo->toArray();

        $promociones = $this->obtenerPromociones();

        $enviarVista = [
            'promociones'   => $promociones,
            'tipoPlatillos' => $busquedaPlatillo
        ];
        return response()->json([
            'respuesta' => $enviarVista
        ], 200);
    }

    public function obtenerPromociones()
    {
        $buscarPromociones = promocion::select('tipo_promocion')
            ->get();
        $buscarPromociones->toArray();
        return $buscarPromociones;
    }


}
