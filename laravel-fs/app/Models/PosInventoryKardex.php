<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosInventoryKardex extends Model
{
    use EncryptationId;

    protected $table = 'pos_inventory_kardexes';

    protected $fillable = ['id', 'pos_inventory_id', 'action_id', 'date_from', 'date_until'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['crypt_id'];
}
