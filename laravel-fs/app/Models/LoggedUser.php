<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class LoggedUser extends Model
{
    use EncryptationId;

    protected $table = 'logged_users';

    protected $fillable = [
        'id',
        'user_id',
        'date_in',
        'ip',
    ];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
