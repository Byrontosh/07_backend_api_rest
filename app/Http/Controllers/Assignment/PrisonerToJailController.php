<?php

namespace App\Http\Controllers\Assignment;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Http\Resources\UserResource;
use App\Models\Jail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class PrisonerToJailController extends Controller
{
    // Creación del constructor
    public function __construct()
    {
        // Uso del gate para que pueda asignar prisioneros a cárceles a partir del rol establecido
        $this->middleware('can:manage-assignment');

        // Uso del middleware para que pueda asignar prisioneros a cárceles a partir del rol establecido
        $this->middleware('verify.jail.assignment')->only('assign');
    }



    // Métodos del Controlador
    // Listar los prisioneros y cárceles disponibles
    public function index()
    {
        // Traer el rol prisionero
        $role = Role::where('slug', "prisoner")->first();

        // Traer los usuarios a partir de ese rol
        $prisoners = $role->users;

        // https://laravel.com/docs/9.x/eloquent#cursors
        // https://laravel.com/docs/9.x/collections#method-filter
        // Por cada cárcel que se va a iterar
        $jails = Jail::cursor()->filter(function ($jail)
        {
            // Se obtiene el número de usuarios (prisioneros)
            $total_users = $jail->users->count();

            // Se retorna los registros a partir de la siguiente condición
            return $jail->capacity > $total_users && $jail->state;

        // https://laravel.com/docs/9.x/collections#method-listing
        })->all();


        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por los respectivos Resources
        return $this->sendResponse(message: 'Assignment between prisoners and jails generated successfully', result: [
            'users' => UserResource::collection($prisoners),
            'jails' => SpaceResource::collection($jails)
        ]);
    }



    // Método para realizar la asignación respectiva
    public function assign(User $user, Jail $jail)
    {

        // Obtener solo los id de las cárceles de los usuarios
        // https://laravel.com/docs/9.x/eloquent-collections#method-modelKeys
        $prisoner_jails_id = $user->jails->modelKeys();

        // https://laravel.com/docs/9.x/eloquent-relationships#syncing-associations
        $user->jails()->syncWithPivotValues($prisoner_jails_id, ['state' => false]);

        $user->jails()->sync([$jail->id]);

        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Assignment updated successfully', result: [
            'user' => new UserResource($user),
            'jail' => $jail
        ]);
    }
}
