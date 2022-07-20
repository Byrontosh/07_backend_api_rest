<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyUserRole
{
    // Función para verificar el rol del usuario
    public function handle(Request $request, Closure $next, string $role_slug)
    {
        // Se obtiene la ruta que gestiona la petición
        $user = $request->route('user');
        // Si el usuario no es el mismo rol
        if (!$user->hasRole($role_slug))
        {
            return abort(403, 'This action is unauthorized.');
        }
        // Si el usuario tiene el mismo rol pasa a realizar las siguientes acciones
        return $next($request);
    }
}
