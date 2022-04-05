<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaBancaria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'data_cuenta_bancarias';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'banco_id',
        'moneda',
        'cuenta_bancaria',
        'person_id',
    ];
}
