<?php

namespace Modules\Contact\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\ChartAccount;
use Modules\Packing\Entities\PackingOrder;
use Modules\Purchase\Entities\PurchaseOrder;
use Modules\Sale\Entities\Sale;
use Modules\Setup\Entities\Country;
use Modules\Setup\Entities\IntroPrefix;

class ContactModel extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'contact_type',
        'name',
        'business_name',
        'tax_number',
        'opening_balance',
        'pay_term',
        'pay_term_condition',
        'customer_group',
        'credit_limit',
        'email',
        'username',
        'mobile',
        'alternate_contact_no',
        'country_id',
        'state',
        'city',
        'note',
        'avatar',
        'address',
        'created_by',
        'updated_by',
    ];

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($model): void {
            $model->created_by = Auth::user()->id ?? null;
        });
        static::created(function ($model): void {
            $id = sprintf('%05d', $model->id);
            $model->contact_id = $model->contact_type == 'Customer' ? IntroPrefix::find(6)->prefix . '-1' . $id : IntroPrefix::find(7)->prefix . '-2' . $id;
            $model->save();
        });

        static::updating(function ($model): void {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeSupplier($query)
    {
        return $query->where('contact_type', 'Supplier');
    }

    public function scopeCustomer($query)
    {
        return $query->where('contact_type', 'Customer');
    }

    public function scopeWitoutWalkInCustomer($query)
    {
        return $query->where('id', '!=', 1)->where('is_active', 1)->where('contact_type', 'Customer');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function chartAccount()
    {
        return $this->hasOne(ChartAccount::class);
    }

    public function purchases()
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id');
    }

    public function packing_orders()
    {
        return $this->hasMany(PackingOrder::class, 'supplier_id');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }

    public function accounts()
    {
        return $this->morphMany(ChartAccount::class, 'contactable');
    }

    public function getTotalInvoiceAttribute()
    {
        if ($this->contact_type == 'supplier') {
            return $this->purchases()->count();
        }

        return $this->sales()->count();
    }

    public function getDueInvoiceAttribute()
    {
        if ($this->contact_type == 'customer') {
            return $this->purchases()->where('status', 0)->count();
        }

        return $this->sales()->where('status', 0)->count();
    }

    public function getAccountsAttribute()
    {
        $paid_amount = 0;
        $sales_return_amount = 0;
        $debit_amount = 0;
        $crebit_amount = 0;
        $total_amount = 0;
        $opening_balance = $this->opening_balance ?: 0;
        if ($this->contact_type == 'Customer') {
            $sales = $this->sales;
            $payable_amount = $sales->sum('payable_amount');

            $chart_account = ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $this->id)->first();

            foreach ($sales as $sale) {
                $paid_amount += ($sale->payments->sum('amount') - $sale->payments->sum('return_amount'));
                $sales_return_amount += $sale->items->sum('return_amount');
            }
            $total_amount = $payable_amount + $opening_balance - $sales_return_amount;
            $due_amount = $chart_account->BalanceAmount + $opening_balance;

            $accounts['total'] = $total_amount;
            $accounts['paid'] = $paid_amount;
            $accounts['due'] = $due_amount;
            $accounts['total_invoice'] = count($sales);
            $accounts['due_invoice'] = count($sales->where('status', '!=', 1));

            return $accounts;
        }
        $purchases = $this->purchases;
        $payable_amount = $purchases->sum('payable_amount');

        $paid_amount = 0;
        $purchase_return_amount = 0;
        $debit_amount = 0;
        $crebit_amount = 0;
        $total_amount = 0;
        $chart_account = ChartAccount::where('contactable_type', 'Modules\Contact\Entities\ContactModel')->where('contactable_id', $this->id)->first();
        foreach ($purchases as $purchase) {
            $purchase_return_amount += $purchase->items->sum('return_amount');
            $paid_amount += ($purchase->payments->sum('amount') - $purchase->payments->sum('return_amount'));
        }

        $total_purchase_amount = $payable_amount + $opening_balance - $purchase_return_amount;
        $due_amount = $chart_account->BalanceAmount + $opening_balance;

        $accounts['total'] = $total_purchase_amount;
        $accounts['paid'] = $paid_amount;
        $accounts['due'] = $due_amount;
        $accounts['total_invoice'] = count($purchases);
        $accounts['due_invoice'] = count($purchases->where('is_paid', '!=', 2));

        return $accounts;
    }

    public function lastInvoice()
    {
        return $this->hasOne(Sale::class, 'customer_id')->latest();
    }
}
