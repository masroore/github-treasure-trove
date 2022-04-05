<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telefono extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_telefonos';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'operador_id',
        'sistema_id',
        'telefono',
        'person_id',
    ];
}
