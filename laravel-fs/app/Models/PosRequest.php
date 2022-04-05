<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosRequest extends Model
{
    use EncryptationId;

    protected $table = 'pos_requests';

    protected $fillable = ['id', 'storage_id', 'user_id', 'date_register', 'ip', 'storage_request_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['details', 'crypt_id', 'storage', 'user', 'storage_request_name', 'user_name', 'storage_name', 'serial_shipment'];

    public function getDetails()
    {
        return $this->hasMany(PosRequestDetail::class, 'pos_request_id');
    }

    public function getDetailsAttribute()
    {
        return $this->getDetails;
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPosShipment()
    {
        return $this->hasMany(PosShipment::class, 'pos_request_id');
    }

    public function getStorage()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }

    public function getStorageRequest()
    {
        return $this->belongsTo(Storage::class, 'storage_request_id');
    }

    public function getUserAttribute()
    {
        return $this->getUser;
    }

    public function getStorageAttribute()
    {
        return $this->getStorage;
    }

    public function getStorageNameAttribute()
    {
        return $this->getStorage->name_storage;
    }

    public function getStorageRequestNameAttribute()
    {
        return $this->getStorageRequest->name_storage;
    }

    public function getUserNameAttribute()
    {
        return $this->getUser->name_user . ' ' . $this->getUser->surname_user;
    }

    public function getPosShipmentAttribute()
    {
        return $this->getPosShipment;
    }

    public function getSerialShipmentAttribute()
    {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
