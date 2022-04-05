<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TypeAccount extends Model
{
    use EncryptationId;

    protected $table = 'type_accounts';

    protected $fillable = ['id', 'name_product', 'status', 'type_coin_id', 'bank_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['bank_name', 'name_coin', 'crypt_id'];

    public function getBanks()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function getTypeCoin()
    {
        return $this->belongsTo(TypeCoin::class, 'type_coin_id');
    }

    public function getBankNameAttribute()
    {
        return $this->getBanks->name_bank;
    }

    public function getNameCoinAttribute()
    {
        return $this->getTypeCoin->name_coin;
    }
}
