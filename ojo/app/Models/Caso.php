<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Caso extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'casos';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'isFlagrancia',
        'isBanda',
        'banda',
        'denuncia',
        'entidad_id',
        'entidad',
        'documento_id',
        'documento',
        'fecha_recepcion',
        'fecha_expiracion',
        'plazo',
        'fiscalia',
        'carpeta_fiscal',
        'delito_id',
        'modalidad_id',
        'banco_id',
        'cantidad',
        'moneda_id',
        'investigador_id',
    ];
}
