<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyJailAssignment
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
        // Obtener desde el Request la cárcel
        $jail = $request->route('jail');


        // Si el usuario no tiene un estado
        // Si el usuario no tiene el rol prisionero
        // Si la cárcel no tiene un estado
        if (!$user->state || !$user->hasRole("prisoner") || !$jail->state)
        {
            return abort(403, 'This action is unauthorized.');
        }
        // Obtener la cárcel de donde esta el usuario
        // https://laravel.com/docs/9.x/eloquent#updates
        $user_jail = $user->jails->first();
        // Si el usuario ya esta asignado a una carcel y
        // Si el id de la cárcel es igual al id de la cárcel del request
        if ($user_jail && $user_jail->id === $jail->id)
        {
            return abort(403, 'The prisoner is already assigned to that jail.');
        }
        // Si la capacidad de la cárcel es mayor o igual a la capacidad establecida
        if ($jail->users->count() >= $jail->capacity)
        {
            return abort(403, "The jail is already assigned to that {$jail->capacity} prisoners.");
        }

        // Si la cárcel tiene espacio y el rol del usuario es prisionero y esta activo
        // pasa a realizar las siguientes acciones
        return $next($request);
    }
}
