<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class ConnectionMechanism extends Model
{
    use EncryptationId;

    protected $table = 'connection_mechanisms';

    protected $fillable = ['id', 'name_conection', 'status', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
