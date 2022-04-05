<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class ClientRepresentative extends Model
{
    use EncryptationId;

    protected $table = 'client_representatives';

    protected $fillable = ['id', 'position', 'representative_id', 'type_representative_id', 'client_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id', 'representative'];

    public function getRepresentativeAttribute()
    {
        return $this->getRepresentative;
    }

    public function getRepresentative()
    {
        return $this->belongsTo('App\Models\Representative', 'representative_id');
    }

    public function getTypeRepresentative()
    {
        return $this->belongsTo('App\Models\TypeRepresentative', 'type_representative_id');
    }

    public function getClient()
    {
        return $this->belongsTo('App\Models\Client', 'client_id');
    }
}
