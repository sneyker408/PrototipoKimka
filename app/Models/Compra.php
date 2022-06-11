<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    //relacion de 1:N con detalle_compras
    public function detalle_compras() {
        return $this->hasMany(Detalle_compras::class, 'id');
    }
    //Por la relacion inversa de proveedores
    public function proveedores() {
        return $this->belongsTo(Proveedores::class, 'proveedores_id');
    }
}
