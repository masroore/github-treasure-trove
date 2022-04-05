<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use EncryptationId;

    protected $table = 'actions';

    protected $fillable = ['id', 'name_action'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
