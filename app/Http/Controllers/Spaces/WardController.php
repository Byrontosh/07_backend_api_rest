<?php

namespace App\Http\Controllers\Spaces;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpaceResource;
use App\Http\Resources\WardResource;
use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{

    // Creación del constructor
    public function __construct()
    {
        // Uso del gate para que pueda gestionar las cárceles a partir del rol establecido
        $this->middleware('can:manage-wards');
    }

    // Métodos del Controlador
    // Listar los pabellones
    public function index()
    {
        // Obtener la colección de pabellones
        $wards = Ward::orderBy('name', 'asc')->get();
        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Ward list generated successfully', result: [
            'wards' => SpaceResource::collection($wards)
        ]);
    }

    // Crear un nuevo pabellon
    public function store(Request $request)
    {
         // Validación de los datos de entrada
         // Crear un array asociativo de clave y valor
        $ward_data = $request -> validate([
            'name' => ['required', 'string', 'min:3', 'max:45'],
            'location' => ['required', 'string', 'min:3', 'max:45'],
            'description' => ['nullable', 'string', 'min:5', 'max:255'],
        ]);

        // https://laravel.com/docs/9.x/eloquent#inserts
        Ward::create($ward_data);
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Ward stored successfully');
    }


    // Mostrar la información del pabellon
    public function show(Ward $ward)
    {
        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Ward details', result: [
            'ward' => new WardResource($ward)
        ]);
    }


    // Actualizar la información del pabellon
    public function update(Request $request, Ward $ward)
    {
         // Validación de los datos de entrada
         // Crear un array asociativo de clave y valor
        $ward_data = $request -> validate([
            'name' => ['required', 'string', 'min:3', 'max:45'],
            'location' => ['required', 'string', 'min:3', 'max:45'],
            'description' => ['nullable', 'string', 'min:5', 'max:255'],
        ]);

        // Actaliza los datos del pabellon
        $ward->fill($ward_data)->save();

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Ward updated successfully');
    }

    // Dar de baja a un pabellon
    public function destroy(Ward $ward)
    {
        // Obtener el estado del pabellon
        $ward_state = $ward->state;

        // Almacenar un string con el mensaje
        $message = $ward_state ? 'inactivated' : 'activated';

        // Verifica que el pabellon tiene guardias
        if ($ward->users->isNotEmpty())
        {
            return $this->sendResponse(message: 'This ward has assigned guard(s)', code: 403);
        }
        // Cambia el estado del pabellon
        $ward->state = !$ward_state;

        // Guardar en la BDD
        $ward->save();

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: "Ward $message successfully");
    }
}
