<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TypeContract extends Model
{
    use EncryptationId;

    protected $appends = ['crypt_id'];
}
