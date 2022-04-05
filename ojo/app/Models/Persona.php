<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'personas';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombres',
        'paterno',
        'materno',
        'tipo_documento',
        'numero_documento',
        'edad',
        'sexo',
        'pais_id',
        'region_id',
        'provincia_id',
        'distrito_id',
        'direccion',
        'coordenadas',
    ];
}
