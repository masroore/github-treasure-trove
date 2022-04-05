<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use EncryptationId;

    protected $table = 'connections';

    protected $fillable = ['id', 'model_id', 'connection_mechanisms_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
