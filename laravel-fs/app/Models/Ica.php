<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class Ica extends Model
{
    use EncryptationId;

    protected $table = 'icas';

    protected $fillable = ['id', 'code', 'bank_id', 'type_coin_id', 'status', 'user_id', 'register_date', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['type_coin', 'ica_bin', 'ica_process', 'crypt_id'];

    public $timestamps = false;

    public function getTypeCoinAttribute()
    {
        return $this->getTypeCoin->name_coin;
    }

    public function getIcaBinAttribute()
    {
        return $this->getBin;
    }

    public function getIcaProcessAttribute()
    {
        return $this->getProcess;
    }

    public function getTypeCoin()
    {
        return $this->belongsTo('App\Models\TypeCoin', 'type_coin_id');
    }

    public function getUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function getBin()
    {
        return $this->hasMany(IcaBin::class, 'ica_id');
    }

    public function getProcess()
    {
        return $this->hasMany(IcaIdProcess::class, 'ica_id');
    }
}
