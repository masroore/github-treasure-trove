<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TelephoneOperator extends Model
{
    use EncryptationId;

    protected $table = 'telephone_operators';

    protected $fillable = ['id', 'code', 'description', 'country_id', 'type_operator_id'];

    protected $connection = 'mysql';

    protected $appends = ['country', 'crypt_id'];

    public $timestamps = false;

    public function getCountryAttribute()
    {
        return $this->belongsTo(Country::class, 'country_id')->get()->toArray();
    }
}
