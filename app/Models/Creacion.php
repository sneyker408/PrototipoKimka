<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creacion extends Model
{
    use HasFactory;
    //Por la relacion inversa con categoria
    public function categoria() {
        return $this->belongsTo(Categoria::class,'categoria_id');
    }

    //Por la relacion inversa con color
    public function color() {
        return $this->belongsTo(Color::class,'color_id');
    }
}
