<?php

namespace App\Models;

use App\Traits\EncryptationId;
use Illuminate\Database\Eloquent\Model;

class PosShipmentDetail extends Model
{
    use EncryptationId;

    protected $table = 'pos_shipment_details';

    protected $fillable = ['id', 'recived', 'pos_shipments_id', 'pos_boxes_id'];

    protected $connection = 'mysql';

    public $timestamps = false;

    protected $appends = ['boxes', 'crypt_id'];

    public function getBoxes()
    {
        return $this->belongsTo(PosBoxe::class, 'pos_boxes_id');
    }

    public function getBoxesAttribute()
    {
        return $this->getBoxes;
    }
}
