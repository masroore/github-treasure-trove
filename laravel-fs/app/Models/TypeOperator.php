<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TypeOperator extends Model
{
    use EncryptationId;

    protected $table = 'type_operators';

    protected $fillable = ['id', 'description'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
