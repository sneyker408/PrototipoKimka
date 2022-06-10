<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    //Relacion de 1:N con Creaciones
    public function creaciones() {
        //return $this->hasMany('App\Models\creacion');
        return $this->hasMany(Creacion::class,'id');
    }
}
