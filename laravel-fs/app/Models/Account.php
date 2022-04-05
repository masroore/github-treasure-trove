<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    use EncryptationId;

    protected $table = 'accounts';

    protected $fillable = ['id', 'code_account', 'status', 'type_account_id', 'client_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    protected $appends = ['crypt_id', 'account', 'description_account', 'client_pos'];

    public $timestamps = false;

    public function getAccountAttribute()
    {
        if (Auth::User()->sensitive_info == 0) {
            return substr($this->code_account, 0, 4) . '****' . substr($this->code_account, 16, 20);
        }

        return $this->code_account;
    }

    public function getDescriptionAccountAttribute()
    {
        if (Auth::User()->sensitive_info == 0) {
            return substr($this->code_account, 0, 4) . '****' . substr($this->code_account, 16, 20) . ' (' . $this->getTypeAccount->name_product . ')';
        }

        return $this->code_account . ' (' . $this->getTypeAccount->name_product . ')';
    }

    public function getTypeAccount()
    {
        return $this->belongsTo('App\Models\TypeAccount', 'type_account_id');
    }

    public function getClientPosAttribute()
    {
        return $this->getClientPos;
    }

    public function getClientPos()
    {
        return $this->hasMany(ClientPos::class, 'account_id');
    }
}
