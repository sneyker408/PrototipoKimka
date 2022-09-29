<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = ['codigo','nombre','descripcion','fecha_pedido','fecha_entrega','estado','cliente_id','user_id'];


    public function categorias(){
        return $this->hasMany('App\Models\Cliente');
    }

    public function marcas(){
        return $this->hasMany('App\Models\User');
    }

}
