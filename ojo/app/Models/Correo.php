<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Correo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_correos';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'correo',
        'person_id',
    ];
}
