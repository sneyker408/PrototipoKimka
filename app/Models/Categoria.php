<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    //Relacion de 1:N con articulos
    public function articulos() {
        //return $this->hasMany('App\Models\articulos');
        return $this->hasMany(Articulo::class,'id');
    }

}