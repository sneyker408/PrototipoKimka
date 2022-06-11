<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    //Por la relacion inversa con clientes
    public function clientes() {
        return $this->belongsTo(Cliente::class, 'clientes_id');
    }
    //relacion de 1:N con creaciones
    public function creaciones() {
        return $this->hasMany(Creacion::class, 'creaciones_i');
    }
}
