<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;

    //Por la relacion inversa con categoria
    public function categoria() {
        return $this->belongsTo(Categoria::class,'categoria_id');
    }

    //relacion de 1:N con detalle_ventas
    public function detalle_ventas() {
        return $this->hasMany(Detalle_venta::class,'id');
    }
    //relacion de 1:N con creaciones 
    public function creaciones() {
        return $this->hasMany(Creacione::class, 'id');
    }
    //Por la relacion inversa con detalle_compras
    public function detalle_compras() {
        return $this->belongsTo(detalle_compra::class, 'detalle_compras_id');
    }

    public function colores(){
        return $this->hasMany('App\Models\Color');
    }

}
