<?php

namespace Modules\Sale\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\TimePeriodAccount;
use Modules\Account\Entities\Voucher;
use Modules\Contact\Entities\ContactModel;
use Modules\Inventory\Entities\WareHouse;
use Modules\Product\Entities\ProductHistory;
use Modules\Product\Entities\ProductItemDetailPartNumber;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Setup\Entities\IntroPrefix;

class Sale extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['document' => 'array'];

    public function product_item_details_part_numbers()
    {
        return $this->hasMany(ProductItemDetailPartNumber::class);
    }

    public function saleable()
    {
        return $this->morphTo();
    }

    public function refers()
    {
        return $this->morphMany(Voucher::class, 'referable');
    }

    public function items()
    {
        return $this->morphMany(ProductItemDetail::class, 'itemable');
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getBillingAmountAttribute()
    {
        $paid_amount = $this->payments()->sum('amount');
        $due_amount = $this->payable_amount - $paid_amount;

        return [
            'due_amount' => $due_amount,
            'paid_amount' => $paid_amount,
        ];
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function agentuser()
    {
        return $this->belongsTo(User::class, 'agent_user_id');
    }

    public function customer()
    {
        return $this->belongsTo(ContactModel::class, 'customer_id')->withDefault();
    }

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'ware_house_id');
    }

    public function getSaleProductsAttribute()
    {
        return $this->items->pluck('product_id')->toArray();
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class)->latest();
    }

    public function getGrandTotalAttribute()
    {
        $grand_total = 0;
        $sale_item_details = $this->items;
        foreach ($sale_item_details as $key => $item) {
            $price_after_discount = $item->price - $item->discount;
            $price_with_tax = (($price_after_discount / 100) * $item->tax);
            $grand_total += ($item->price + $price_with_tax) * $item->quantity;
        }

        return $grand_total;
    }

    public function getSubTotalAttribute()
    {
        $total_due = 0;
        $this_due = 0;
        $tax = 0;
        $discountProductTotal = 0;
        $subTotalAmount = 0;
        foreach ($this->items as $product) {
            $subTotalAmount += $product->price * $product->quantity;
        }

        return $subTotalAmount;
    }

    public function getProductWiseTaxtAttribute()
    {
        $tax = 0;
        foreach ($this->items as $product) {
            $prductDiscount = $product->price * $product->discount / 100;

            $tax += (($product->price - $prductDiscount) * $product->quantity) * $product->tax / 100;
        }

        return $tax;
    }

    public function getProductWiseDiscountAttribute()
    {
        $discountProductTotal = 0;
        $subTotalAmount = 0;
        foreach ($this->items as $product) {
            $prductDiscount = $product->price * $product->discount / 100;

            $tax += (($product->price - $prductDiscount) * $product->quantity) * $product->tax / 100;

            if ($product->discount > 0) {
                $discountProductTotal += $prductDiscount * $product->quantity;
            }
        }

        return $discountProductTotal;
    }

    public static function boot(): void
    {
        parent::boot();

        static::created(function ($model): void {
            $model->invoice_no = IntroPrefix::find(3)->prefix . '-' . date('y') . date('m') . Auth::id() . $model->id;
            $model->created_by = Auth::user()->id ?? null;
            $model->save();
        });

        static::updating(function ($model): void {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function scopePayment($query, $type)
    {
        if ($type == 'today') {
            return $query->whereDate('date', Carbon::today());
        }
        if ($type == 'week') {
            return $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }
        if ($type == 'month') {
            return $query->whereMonth('date', Carbon::now());
        }
        if ($type == 'year') {
            $time_period = TimePeriodAccount::where('is_closed', 0)->latest()->first();

            return $query->whereBetween('created_at', [$time_period->start_date, $time_period->end_date]);
        }

        return $query;
    }
}
