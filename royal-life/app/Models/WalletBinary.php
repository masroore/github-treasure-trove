<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletBinary extends Model
{
    use HasFactory;

    protected $table = 'wallet_binaries';

    protected $fillable = [
        'iduser', 'referred_id', 'orden_purchase_id',
        'puntos_d', 'puntos_i', 'side', 'descripcion',
        'status',
    ];
}
