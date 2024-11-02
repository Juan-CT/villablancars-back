<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $fillable = [
        'coche_id',
        'url'
    ];

    protected $table = 'imagenes';

    public function coche() {
        return $this->belongsTo(Coche::class);
    }
}
