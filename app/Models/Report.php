<?php

namespace App\Models;

use App\Trait\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory, HasImage;
    
    protected $fillable = ['title', 'description'];


    // Relación de uno a muchos
    // Un reporte le pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación polimórfica uno a uno
    // Un reporte pueden tener una imagen
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }

    // Obtener el avatar por default
    public function getDefaultReportImagePath()
    {
        return env('DEFAULT_USER_AVATAR','https://lifeskillsaustralia.com.au/wp-content/uploads/2019/07/assessment.png');
    }

    public function getImagePath()
    {
        // se obtiene la relación de los modelos usuario e imagen
        // se verifica no si existe un Modelo
        if (!$this->image)
        {
            // asignarle el path de una imagen por defecto
            return $this->getDefaultReportImagePath();
        }
        // retornar el path de la imagen registrada en la BDD
        return $this->image->path;
    }


}
