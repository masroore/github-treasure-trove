<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class IcaBin extends Model
{
    use EncryptationId;

    protected $table = 'ica_bins';

    protected $fillable = ['id', 'code', 'description_bin', 'status', 'ica_id', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id'];

    public $timestamps = false;
}
