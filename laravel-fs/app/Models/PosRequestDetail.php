<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosRequestDetail extends Model
{
    use EncryptationId;

    protected $table = 'pos_request_details';

    protected $fillable = ['id', 'quantity', 'pos_request_id', 'model_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['model', 'crypt_id'];

    public function getModels()
    {
        return $this->belongsTo(Models::class, 'model_id');
    }

    public function getModelAttribute()
    {
        return $this->getModels->mark . ' ' . $this->getModels->serial;
    }
}
