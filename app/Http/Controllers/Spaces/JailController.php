<?php

namespace App\Http\Controllers\Spaces;

use App\Http\Controllers\Controller;
use App\Http\Resources\JailResource;
use App\Http\Resources\SpaceResource;
use App\Models\Jail;
use Illuminate\Http\Request;

class JailController extends Controller
{

    // Creación del constructor
    public function __construct()
    {
        // Uso del gate para que pueda gestionar las cárceles a partir del rol establecido
        $this->middleware('can:manage-jails');
    }


    // Métodos del Controlador
    // Listar las cárceles
    public function index()
    {
        // Obtener la colección de cárceles
        $jails = Jail::orderBy('name', 'asc')->get();

        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Jail list generated successfully', result: [
            'jails' => SpaceResource::collection($jails)
        ]);
    }

    // Crear una nueva cárcel
    public function store(Request $request)
    {
         // Validación de los datos de entrada
         // Crear un array asociativo de clave y valor
        $jail_data = $request -> validate([
            'name' => ['required', 'string', 'min:3', 'max:45'],
            // https://laravel.com/docs/9.x/validation#rule-alpha-dash
            'code' => ['required', 'string', 'alpha_dash', 'min:5', 'max:45'],
            'type' => ['required', 'string'],
            'capacity' => ['required', 'string', 'numeric', 'digits:1', 'min:2', 'max:5'],
            // https://laravel.com/docs/9.x/validation#rule-exists
            'ward_id' => ['required', 'string', 'numeric', 'exists:wards,id'],
            'description' => ['nullable', 'string', 'min:5', 'max:255'],
        ]);

        // https://laravel.com/docs/9.x/eloquent#inserts
        Jail::create($jail_data);
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Jail stored successfully');
    }


    // Mostrar la información de la cárcel
    public function show(Jail $jail)
    {
        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Jail details', result: [
            'jail' => new JailResource($jail)
        ]);
    }


    // Actualizar la información de la cárcel
    public function update(Request $request, Jail $jail)
    {
         // Validación de los datos de entrada
         // Crear un array asociativo de clave y valor
        $jail_data = $request -> validate([
            'name' => ['required', 'string', 'min:3', 'max:45'],
            // https://laravel.com/docs/9.x/validation#rule-alpha-dash
            'code' => ['required', 'string', 'alpha_dash', 'min:5', 'max:45'],
            'type' => ['required', 'string'],
            // https://laravel.com/docs/9.x/validation#rule-digits
            'capacity' => ['required', 'string', 'numeric', 'digits:1', 'min:2', 'max:5'],
            // https://laravel.com/docs/9.x/validation#rule-exists
            'ward_id' => ['required', 'string', 'numeric', 'exists:wards,id'],
            'description' => ['nullable', 'string', 'min:5', 'max:255'],
        ]);

        // Actaliza los datos de la cárcel
        $jail->fill($jail_data)->save();

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Jail updated successfully');
    }


    // Dar de baja a una cárcel
    public function destroy(Jail $jail)
    {
        // Obtener el estado de la carcel
        $jail_state = $jail->state;

        // Almacenar un string con el mensaje
        $message = $jail_state ? 'inactivated' : 'activated';

        // Verifica que la carcel tiene prisioneros
        if ($jail->users->isNotEmpty())
        {
            // Invoca el controlador padre para la respuesta json
            return $this->sendResponse(message: 'This jail has assigned prisoner(s)', code: 403);
        }

        // Cambia el estado de la cárcel
        $jail->state = !$jail_state;

        // Guardar en la BDD
        $jail->save();

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: "Jail $message successfully");
    }
}
