<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Venta extends Model
{
    use HasFactory;
    //Por la realcion de N:1 con articulos
    public function articulos() {
        return $this->belognsMany(Articulo::class, 'articulos_id');
    }
    //Por la relacion de N:1 con ventas
    public function ventas() {
        return $this->belongsToMany(Venta::class, 'ventas_id');
    }
}
