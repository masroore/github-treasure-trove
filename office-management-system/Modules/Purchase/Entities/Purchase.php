<?php

namespace Modules\Purchase\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\Voucher;
use Modules\Contact\Entities\ContactModel;
use Modules\Product\Entities\ProductHistory;
use Modules\Sale\Entities\Payment;
use Modules\Setup\Entities\IntroPrefix;

class Purchase extends Model
{
    protected $table = 'purchase_orders';

    protected $guarded = ['id'];

    protected $casts = ['documents' => 'array'];

    public static function boot(): void
    {
        parent::boot();
        static::created(function ($model): void {
            $model->invoice_no = IntroPrefix::find(2)->prefix . '-' . date('y') . date('m') . Auth::id() . $model->id;
            $model->created_by = Auth::id();
            $model->save();
        });
        static::updated(function ($model): void {
            $model->updated_by = Auth::id();
            $model->save();
        });
    }

    public function cnf()
    {
        return $this->belongsTo(CNF::class, 'cnf_id');
    }

    public function supplier()
    {
        return $this->belongsTo(ContactModel::class, 'supplier_id');
    }

    public function refers()
    {
        return $this->morphMany(Voucher::class, 'referable');
    }

    public function purchasable()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->morphMany(ProductItemDetail::class, 'itemable');
    }

    public function notifications()
    {
        return $this->morphMany(ProductItemDetail::class, 'notifiable');
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }

    public function getItemIdsAttribute()
    {
        return $this->items->pluck('product_id')->toArray();
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }

    public function getBillingAmountAttribute()
    {
        $given_amount = $this->payments()->sum('amount');
        $return_amount = $this->payments()->sum('return_amount');
        $paid_amount = $given_amount - $return_amount;

        return [
            'given_amount' => $given_amount,
            'return_amount' => $return_amount,
            'paid_amount' => $paid_amount,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
