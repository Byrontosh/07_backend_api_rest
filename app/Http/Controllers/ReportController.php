<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // Se procede a establecer un atributo para el manejo del directorio de las imagenes
    private string $directory_name = 'reports';
    
    public function __construct()
    {
        // https://laravel.com/docs/9.x/authorization#authorizing-resource-controllers
        $this->authorizeResource(Report::class, 'report');
    }


    // Métodos del Controlador
    // Listar los reportes
    public function index()
    {
        // Se obtiene el usuario autenticado
        $user = Auth::user();
        // Del usuario se obtiene los reportes
        $reports = $user->reports;
        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Report list generated successfully', result: [
            'reports' => ReportResource::collection($reports)
        ]);
    }

    // Crear un nuevo reporte
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'title' => ['required', 'string', 'min:5', 'max:45'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:512'], //max image size is 512 kb
        ]);

        // Del request se obtiene unicamente los dos campos
        $report_data = $request->only(['title', 'description']);
        // Se crea una nueva instancia (en memoria)
        $report = new Report($report_data);
        // Se obtiene el usuario autenticado
        $user = Auth::user();
        // Del usuario se almacena su reporte en base a la relación
        // https://laravel.com/docs/9.x/eloquent-relationships#the-save-method
        $user->reports()->save($report);
        // Si del request se tiene una imagen se invoca al helper
        if ($request->has('image'))
        {
            $image_path = ImageHelper::getLoadedImagePath(
                uploaded_image: $request['image'],
                directory: $this->directory_name
            );
            // se hace uso del Trait para asociar esta imagen con el modelo report
            $report->attachImage($image_path);
        }

        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Report stored successfully');
    }

    // Mostrar la información del reporte
    public function show(Report $report)
    {

        // Invoca el controlador padre para la respuesta json
        // El moldeo de la información por el Resource
        return $this->sendResponse(message: 'Report details', result: [
            'report' => new ReportResource($report),
        ]);
    }

    // Actualizar la información del reporte
    public function update(Request $request, Report $report)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'title' => ['required', 'string', 'min:5', 'max:45'],
            'description' => ['required', 'string', 'min:5', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:512'], //max image size is 512 kb
        ]);

        // Del request se obtiene unicamente los dos campos
        $report_data = $request->only(['title', 'description']);
        // Actaliza los datos del reporte
        $report->fill($report_data)->save();

        // Si del request se tiene una imagen se invoca al helper
        if ($request->has('image'))
        {
            $image_path = ImageHelper::getLoadedImagePath(
                uploaded_image: $request['image'],
                previous_image_path: $report->image?->path,
                directory: $this->directory_name
            );
            // se hace uso del Trait para asociar esta imagen con el modelo report
            $report->attachImage($image_path);
        }
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: 'Report updated successfully');
    }

    // Dar de baja a un pabellon
    public function destroy(Report $report)
    {
        // Obtener el estado del reporte
        $report_state = $report->state;
        // Almacenar un string con el mensaje
        $message = $report_state ? 'inactivated' : 'activated';
        // Cambia el estado del pabellon
        $report->state = !$report_state;
        // Guardar en la BDD
        $report->save();
        // Invoca el controlador padre para la respuesta json
        return $this->sendResponse(message: "Report $message successfully");
    }


}
