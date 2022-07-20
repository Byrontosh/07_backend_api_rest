<?php

// Establecer el path del Trait
namespace App\Trait;

use App\Models\Image;


// https://replit.com/@ByronLoarte/18-Traits#index.php
// https://www.php.net/manual/es/language.oop5.traits.php


trait HasImage
{

    // Función para manejar la relación polimorfica
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


    // función para agregar la imagen en la BDD
    public function attachImage(string $image_path)
    {
        // se obtiene el modelo Image mediante la propiedad image
        $previous_image = $this->image;
        // si la imagen es vacía
        if (is_null($previous_image))
        {
            // se crea una nueva imagen
            $image = new Image(['path' => $image_path]);
            // se registra en la BDD por medio de la relación
            // https://laravel.com/docs/9.x/eloquent-relationships#the-save-method
            $this->image()->save($image);
        }
        else
        {
            // se actualiza con el path que entra como parametro de entrada
            $previous_image->path = $image_path;
            // se actualiza en la BDD
            $previous_image->save();
        }
    }
}
