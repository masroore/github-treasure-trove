<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class CoinTransaction extends Model
{
    use EncryptationId;

    protected $table = 'coin_transactions';

    protected $fillable = ['id', 'type_coin_id', 'type_transactions_id', 'status', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'type_transaction_name', 'type_coin_name', 'transa_coin'];

    public function getTypeTransaction()
    {
        return $this->belongsTo(TypeTransaction::class, 'type_transactions_id');
    }

    public function getTypeTransactionNameAttribute()
    {
        return $this->getTypeTransaction->name_transaction;
    }

    public function getTransaCoinAttribute()
    {
        return $this->getTypeTransaction->name_transaction . ' ' . $this->getTypeCoin->name_coin;
    }

    public function getTypeCoin()
    {
        return $this->belongsTo(TypeCoin::class, 'type_coin_id');
    }

    public function getTypeCoinNameAttribute()
    {
        return $this->getTypeCoin->name_coin;
    }
}
