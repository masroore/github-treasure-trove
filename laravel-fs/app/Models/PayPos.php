<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PayPos extends Model
{
    use EncryptationId;

    protected $table = 'pay_pos';

    protected $fillable = ['id', 'reference', 'number_account', 'date_pay', 'amount', 'client_pos_id', 'pay_method_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'pay_method'];

    public function getPayMethod()
    {
        return $this->belongsTo(PayMethod::class, 'pay_method_id');
    }

    public function getPayMethodAttribute()
    {
        return $this->getPayMethod->name_pay_method;
    }
}
