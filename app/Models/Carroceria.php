<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carroceria extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function coches()
    {
        return $this->hasMany(Coche::class);
    }
}
