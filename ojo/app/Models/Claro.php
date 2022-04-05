<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claro extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'nombre_completo',
        'fecha_activacion',
        'numero',
        'plan',
    ];
}
