<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class BankLiquidation extends Model
{
    use EncryptationId;

    protected $appends = ['crypt_id'];
}
