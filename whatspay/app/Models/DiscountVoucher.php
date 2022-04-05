<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class DiscountVoucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'discount_type',
        'discount_value',
        'payment_method',
        'countries',
        'limit_type',
        'limit_value',
        'with_promotion',
        'created_by',
        'never_expires',
        'status',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'everytime',
        'min_order',

    ];

    public function usage()
    {
        return $this->hasMany(VoucherUsage::class, 'voucher_id')->where('user_id', Auth::id());
    }

    public function usagetotal()
    {
        return $this->hasMany(VoucherUsage::class, 'voucher_id');
    }

    public function details()
    {
        return $this->hasMany(VoucherDetails::class, 'voucher_id');
    }
}
