<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    protected $fillable = [
        'usuario_id',
        'coche_id',
        'fecha',
        'hora',
        'estado',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function coche()
    {
        return $this->belongsTo(Coche::class);
    }
}
