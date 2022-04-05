<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_address';

    protected $fillable = [
        'address', 'state', 'zip_code', 'country', 'latitude', 'longitude',
    ];
}
