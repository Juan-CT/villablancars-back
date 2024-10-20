<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    // Nombre de tabla a la que corresponde el modelo
    protected $table = 'usuarios';
    // Atributos asignables a la tabla
    protected $fillable = [
        'idFirebase',
        'nombre',
        'email',
    ];

    public $timestamps = true;
}
