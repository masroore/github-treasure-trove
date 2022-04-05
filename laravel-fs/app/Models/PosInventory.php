<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosInventory extends Model
{
    use EncryptationId;

    protected $table = 'pos_inventories';

    protected $fillable = ['id', 'pos_box_id', 'storage_id', 'serial', 'mac_address', 'firmware', 'observations', 'operative', 'avaliable', 'assigned', 'status'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['model_serial', 'model', 'crypt_id', 'storage', 'statuses', 'box_number'];

    public function getStatusesAttribute()
    {
        $Rs = '';
        if ($this->status == 1) {
            $Rs = 'Activo';
        } else {
            $Rs = 'Inactivo';
        }

        return $Rs;
    }

    public function getBoxes()
    {
        return $this->belongsTo(PosBoxe::class, 'pos_box_id');
    }

    public function getStorages()
    {
        return $this->belongsTo(Storage::class, 'storage_id');
    }

    public function getStorageAttribute()
    {
        return $this->getStorages->name_storage;
    }

    public function getModelSerialAttribute()
    {
        return $this->serial;
    }

    public function getModelAttribute()
    {
        return $this->getBoxes->model;
    }

    public function getBoxNumberAttribute()
    {
        return $this->getBoxes->number_box;
    }

    public function FullSerial($serial, $zero = 6)
    {
        return str_pad($serial, $zero, '0', STR_PAD_LEFT);
    }
}
