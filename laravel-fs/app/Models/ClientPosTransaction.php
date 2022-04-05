<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class ClientPosTransaction extends Model
{
    use EncryptationId;

    protected $table = 'client_pos_transactions';

    protected $fillable = ['id', 'coin_transactions_id', 'client_pos_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
