<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Purchase\Entities\ProductItemDetail;

class StockTransfer extends Model
{
    protected $fillable = ['date', 'notes', 'documents', 'receivable_id', 'receivable_type'];

    protected $casts = ['documents' => 'array'];

    public function showroomFrom()
    {
        return $this->belongsTo(WareHouse::class, 'showroom_from');
    }

    public function showroomTo()
    {
        return $this->belongsTo(WareHouse::class, 'showroom_to');
    }

    public function items()
    {
        return $this->morphMany(ProductItemDetail::class, 'itemable');
    }

    public function sendable()
    {
        return $this->morphTo();
    }

    public function receivable()
    {
        return $this->morphTo();
    }
}
