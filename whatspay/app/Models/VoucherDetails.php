<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoucherDetails extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'voucherable_type',
        'voucherable_id',
        'voucher_id',
    ];

    public function voucherable()
    {
        return $this->morphTo();
    }
}
