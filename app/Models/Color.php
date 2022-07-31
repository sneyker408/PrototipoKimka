<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = "colores";
    use HasFactory;
    protected $fillable = ['nombre','articulo_id'];

    public function articulos(){
        return $this->hasMany('App\Models\Articulos');
    }
    
}
