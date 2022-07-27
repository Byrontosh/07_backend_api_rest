<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyWardAssignment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Obtener desde el Request el usuario
        $user = $request->route('user');
        // Obtener desde el Request el pabellon
        $ward = $request->route('ward');

        // Si el usuario no tiene un estado
        // Si el usuario no tiene el rol guardia
        // Si el pabellon no tiene un estado
        if (!$user->state || !$user->hasRole("guard") || !$ward->state)
        {
            return abort(403, 'This action is unauthorized.');
        }

        // Obtener el pabellon de donde esta el usuario
        // https://laravel.com/docs/9.x/eloquent#updates
        $user_ward = $user->wards->first();

        // Si el usuario ya esta asignado a un pabellon y
        // Si el id del pabellon es igual al id del pabellon del request
        if ($user_ward && $user_ward->id === $ward->id)
        {
            return abort(403, 'The guard is already assigned to that ward.');
        }

        // Si la capacidad del pabellon es mayor o igual a la capacidad establecida (2)
        if ($ward->users->count() >= 2)
        {
            return abort(403, 'The ward is already assigned to that 2 guards.');
        }

        // Si el pabellon tiene espacio y el rol del usuario es guardia y esta activo
        // pasa a realizar las siguientes acciones
        return $next($request);
    }
}
