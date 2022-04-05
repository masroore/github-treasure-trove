<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    use EncryptationId;

    protected $table = 'type_documents';

    protected $fillable = ['id', 'code', 'name_document', 'abbreviation', 'type_client_id'];

    protected $connection = 'mysql';

    protected $appends = ['type_client', 'crypt_id'];

    public $timestamps = false;

    public function getTypeClient()
    {
        return $this->belongsTo('App\Models\TypeClient', 'type_client_id');
    }

    public function getTypeClientAttribute()
    {
        return $this->getTypeClient;
    }
}
