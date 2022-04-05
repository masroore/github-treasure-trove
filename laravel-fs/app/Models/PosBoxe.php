<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosBoxe extends Model
{
    use EncryptationId;

    protected $table = 'pos_boxes';

    protected $fillable = ['id', 'number_box', 'initial_serial', 'number_lot', 'model_id', 'pos_register_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['model', 'quantity_pos', 'model_serial', 'serial_end', 'crypt_id'];

    public function getModels()
    {
        return $this->belongsTo(Models::class, 'model_id');
    }

    public function getModelAttribute()
    {
        return $this->getModels->mark . ' ' . $this->getModels->serial;
    }

    public function getModelSerialAttribute()
    {
        return $this->getModels->serial;
    }

    public function getSerialEndAttribute()
    {
        /*
        $cod         = str_pad($this->initial_serial, 6, "0",STR_PAD_LEFT);

        $cod2        = $this->getModels->quantity-$this->initial_serial;
        $cod2        = $this->initial_serial+$cod2;
        $cod2        = str_pad($cod2, 6, "0", STR_PAD_LEFT);
        $mark_serial = $this->getModels->serial;
        return $cod.'/'.$mark_serial.$cod2; */
        return $this->initial_serial . '/' . (((int) $this->initial_serial) + $this->getModels->quantity - 1);
    }

    public function getQuantityPosAttribute()
    {
        return $this->getModels->quantity;
    }
}
