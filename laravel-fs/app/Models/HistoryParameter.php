<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class HistoryParameter extends Model
{
    use EncryptationId;

    protected $table = 'parameters';

    protected $fillable = ['id', 'value_parameters', 'description', 'parameters_id', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
