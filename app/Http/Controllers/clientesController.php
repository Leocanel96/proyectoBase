<?php

namespace App\Http\Controllers;

use App\Models\platillo;
use Illuminate\Http\Request;

class clientesController extends Controller
{
    //
    public function obtenerPlatillosClientes()
    {
        $obtenerPlatillos = platillo::select()
            ->get();

        return response()->json([
            'platillos' => $obtenerPlatillos
        ], 200);
    }
}
