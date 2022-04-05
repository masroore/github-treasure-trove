<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TypeCoin extends Model
{
    use EncryptationId;

    protected $table = 'type_coins';

    protected $fillable = ['id', 'symbol', 'name_coin', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
