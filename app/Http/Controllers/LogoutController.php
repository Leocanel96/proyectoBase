<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function logout()
    {
        // Destruir todas las variables de sesión.
        $_SESSION = array();

// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

// Finalmente, destruir la sesión.
        session_unset();
        session_destroy();

        return response()->json([
            'title'   => 'Sesión finalizada',
            'message' => 'Hasta pronto'
        ], 200);
    }
}
