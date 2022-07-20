<?php

namespace App\Http\Controllers\Account;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request -> validate([
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:512'],
        ]);

        // Se obtiene el usario que esta haciendo el Request
        $user = $request->user();
        // Se invoca la función del helper
        // Pasando a la función la imagen del request
        $uploaded_image_path = ImageHelper::getLoadedImagePath(
            $request['image'],
            // https://styde.net/nuevo-operador-nullsafe-en-php-8/
            $user->image?->path,
            'avatars'
        );

        // Se hace uso del Trait para asociar esta imagen con el modelo user
        $user->attachImage($uploaded_image_path);
        // Uso de la función padre
        return $this->sendResponse('Avatar updated successfully');

    }
}


