<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageHelper
{
    // Función estatica para guardar imagenes en el filesystem del proyecto local o en dropbox
    static function getLoadedImagePath(
        $uploaded_image,
        $previous_image_path = null,
        $directory = 'images',
        $disk = 'dropbox'
    )

    {
         // Guardar en el directorio que se especifique
        $uploaded_image_path = Storage::disk($disk)->put($directory,$uploaded_image);

         // Si existe un path de una imagen previa y si existe en el Storage
         // entonces se procede a eliminar
        if ($previous_image_path && Storage::disk($disk)->exists($previous_image_path))
        {
            Storage::disk($disk)->delete($previous_image_path);
        }

         // Se retorna la ubicación de la imagen
        return $uploaded_image_path;
    }


    // Función estática para obtener la imagen de dropbox
    static function getDiskImageUrl(string $path, string $disk = 'dropbox')
    {
        // https://laravel.com/docs/9.x/helpers#method-starts-with
        // https://laravel.com/docs/9.x/filesystem#file-urls
        return Str::startsWith($path, 'https://')
            ? $path
            : Storage::disk($disk)->url($path);
    }


}
