<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movistar extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro_doc',
        'nombre_completo',
        'Tel1',
        'Tel2',
        'Tel3',
        'Tel4',
        'Tel5',
    ];
}
