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
        'cambio_id',
        'modelo',
        'anio',
        'color',
        'precio',
        'kilometros',
        'autonomia',
        'potencia',
        'descripcion',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function carroceria()
    {
        return $this->belongsTo(Carroceria::class);
    }

    public function cambio()
    {
        return $this->belongsTo(Cambio::class);
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class);
    }
}
