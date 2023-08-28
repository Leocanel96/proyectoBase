<?php

namespace App\Http\Controllers;

use App\Models\platillo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

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
