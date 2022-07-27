<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jail extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'type', 'capacity', 'description', 'ward_id'];


    // Relación de uno a muchos
    // Una cárcel le pertenece a un pabellón
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    // Relación de muchos a muchos
    // Una cárcel puede tener muchos usuarios
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Relación polimórfica uno a uno
    // Una cárcel pueden tener una imagen
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }


}
