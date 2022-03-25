<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken;

class CustomizeToken extends PersonalAccessToken
{
    use HasFactory;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'store_id',
        'user_agent',
        'user_ip',
    ];
}
