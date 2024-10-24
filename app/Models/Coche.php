<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    use HasFactory;

    protected $fillable = [
        'marca_id',
        'carroceria_id',
        'modelo',
        'anio',
        'color',
        'precio',
        'kilometros',
        'cilindrada',
        'potencia',
        'descripcion'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function carroceria()
    {
        return $this->belongsTo(Carroceria::class);
    }
}
