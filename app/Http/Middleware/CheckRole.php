<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            abort(403, 'Acceso denegado. Usuario no autenticado.');
        }

        $rolesArray = explode('|', $roles); // admin|cajero|tecnico

        if (!$request->user()->hasAnyRole($rolesArray)) {
            abort(403, 'Acceso denegado. No tienes los permisos necesarios.');
        }

        return $next($request);
    }
}
