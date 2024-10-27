<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cambio extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
    ];

    public function coches()
    {
        return $this->hasMany(Coche::class);
    }
}
