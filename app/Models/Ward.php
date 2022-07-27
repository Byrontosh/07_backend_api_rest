<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'description'];

    // Relación de uno a muchos
    // Un pabellón puede tener muchas cárceles
    public function jails()
    {
        return $this->hasMany(Jail::class);
    }

    // Relación de muchos a muchos
    // Un pabellón puede tener muchos usuarios
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // Relación polimórfica uno a uno
    // Un pabellón pueden tener una imagen
    public function image()
    {
        return $this->morphOne(Image::class,'imageable');
    }


}
