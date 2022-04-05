<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fiscalia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'fiscalias';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'caso_id',
        'fiscalia',
    ];
}
