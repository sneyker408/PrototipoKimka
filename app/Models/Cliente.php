<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    //relacion de 1:N con pepdidos
    public function pedidos() {
        return $this->hasMany(Pedidos::class, 'id');
    }
    //relacion de 1:N con ventas
    public function ventas() {
        return $this->hasMany(Ventas::class, 'id');
    }
}
