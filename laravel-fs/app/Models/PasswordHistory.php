<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    use EncryptationId;

    protected $table = 'password_histories';

    protected $fillable = ['id', 'user_id', 'password', 'start_date', 'end_date'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
