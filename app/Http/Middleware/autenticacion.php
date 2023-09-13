<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class autenticacion
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        session_start();
        if (!isset($_SESSION['id_user'])) {
            return response(['title' => 'Atención', 'message' => 'Usuario no logeado'], 401);
        }
        return $next($request);
    }
}
