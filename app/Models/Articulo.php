<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

   
    protected $fillable = ['codigo','nombre','descripcion','tipo','precio','existencia','estado','categoria_id','color_id'];


    public function categorias(){
        return $this->hasMany('App\Models\Categoria');
    }

    public function marcas(){
        return $this->hasMany('App\Models\Color');
    }

    public function imagenes(){
        return $this->hasMany('App\Models\Imagen');
    }

}
