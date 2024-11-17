<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'idFirebase',
        'nombre',
        'email',
        'rol'
    ];

    public $timestamps = true;

    public function coches()
    {
        return $this->belongsToMany(Coche::class, 'usuario_coche', 'usuario_id', 'coche_id');
    }

    public function cita()
    {
        return $this->hasMany(Cita::class);
    }
}
