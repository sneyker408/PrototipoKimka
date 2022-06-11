<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    public function detalle_ventas() {
        return $this->hasMany(Detalle_ventas::class, "detalle_ventas_id");
    }

    public function clientes() {
        return $this->belongsTo(Cliente::class, "clientes_id");
    }
}
