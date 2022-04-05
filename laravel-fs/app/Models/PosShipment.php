<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosShipment extends Model
{
    use EncryptationId;

    protected $table = 'pos_shipments';

    protected $fillable = ['id', 'totally_received', 'pos_request_id', 'user_id', 'date_register', 'ip'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['pos_request', 'detail_shipment', 'crypt_id', 'user_name'];

    public function getPosRequest()
    {
        return $this->belongsTo(PosRequest::class, 'pos_request_id');
    }

    public function getPosRequestAttribute()
    {
        return $this->getPosRequest;
    }

    public function getDetailShipment()
    {
        return $this->hasMany(PosShipmentDetail::class, 'pos_shipments_id');
    }

    public function getDetailShipmentAttribute()
    {
        return $this->getDetailShipment;
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getUserNameAttribute()
    {
        return $this->getUser->name_user . ' ' . $this->getUser->surname_user;
    }
}
