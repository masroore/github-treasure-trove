<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'amt',
        'source_id',
        'type',
        'currency_code',
        'status',
    ];
}
