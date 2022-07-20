<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrisonerController extends UserController
{
    // Se crea el constructor para el controlador
    public function __construct()
    {
        // Se porcede a establecer el gate
        // https://laravel.com/docs/9.x/authorization#via-middleware
        $this->middleware('can:manage-prisoners');
        // Se establece el rol para este usuario
        $role_slug = "prisoner";
        // Se establece que si puede recibir notificaciones
        $can_receive_notifications = false;
        // Se hace uso del controlador padre
        parent::__construct($role_slug,$can_receive_notifications);
    }
}
