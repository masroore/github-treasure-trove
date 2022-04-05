<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class ClientPos extends Model
{
    use EncryptationId;

    protected $table = 'client_pos';

    protected $fillable = ['id', 'price', 'status', 'exonerate', 'charged', 'observations', 'account_id', 'pos_inventory_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id', 'pos_model', 'pay_pos'];

    public $timestamps = false;

    public function getPayPos()
    {
        return $this->hasMany(PayPos::class, 'client_pos_id');
    }

    public function getAccount()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function getPosInventory()
    {
        return $this->belongsTo(PosInventory::class, 'pos_inventory_id');
    }

    public function getPosModelAttribute()
    {
        return $this->getPosInventory->model;
    }

    public function getAccountAttribute()
    {
        return $this->getAccount->account;
    }

    public function getPayPosAttribute()
    {
        return $this->getPayPos;
    }
}
