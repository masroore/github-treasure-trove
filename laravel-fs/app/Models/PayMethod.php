<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    use EncryptationId;

    protected $table = 'pay_methods';

    protected $fillable = ['id', 'name_pay_method', 'status', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
