<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TypeClient extends Model
{
    use EncryptationId;

    protected $table = 'type_clients';

    protected $fillable = ['id', 'name_types'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
