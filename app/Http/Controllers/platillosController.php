<?php

namespace App\Http\Controllers;

use App\Models\platillo;

class platillosController extends Controller
{
    //
    public function obtenerPlatillosCreados()
    {
        dd("esta llegando al controller");
        $obtenerPlatillos = platillo::select()
            ->get();
        dd($obtenerPlatillos);
        return response()->json([
            'platillos' => $obtenerPlatillos
        ], 200);
    }

}
