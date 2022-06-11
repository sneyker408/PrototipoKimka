<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detalle_Compra extends Model
{
    use HasFactory;
    //Relacion de 1:N con articulos
    public function articulos() {
        return $this->hasMany(Actirtilo::class, 'id');
    }
    //Por la relacion inversa de compras
    public function compras() {
        return $this->belongsTo(Compra::class, 'compras_id');
    }
}
