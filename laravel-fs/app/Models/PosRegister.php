<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosRegister extends Model
{
    use EncryptationId;

    protected $table = 'pos_registers';

    protected $fillable = ['id', 'number_control', 'provider_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'provider', 'detail_box'];

    public function getProvider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function getProviderAttribute()
    {
        return $this->getProvider;
    }

    public function getDetailBox()
    {
        return $this->hasMany(PosBoxe::class, 'pos_register_id');
    }

    public function getDetailBoxAttribute()
    {
        return $this->getDetailBox;
    }
}
