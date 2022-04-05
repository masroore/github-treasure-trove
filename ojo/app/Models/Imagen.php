<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagen extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_imagenes';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'image_url',
        'descripcion',
        'person_id',
    ];
}
