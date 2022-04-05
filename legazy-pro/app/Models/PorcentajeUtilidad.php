<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PorcentajeUtilidad extends Model
{
    use HasFactory;

    protected $fillable = [
        'porcentaje_utilidad',
    ];
}
