<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RedSocial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_redes_sociales';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'red_social',
        'person_id',
    ];
}
