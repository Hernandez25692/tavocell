<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check() || !$request->user()->hasRole($role)) {
            abort(403, 'Acceso denegado. No tienes el rol requerido.');
        }

        return $next($request);
    }
}
