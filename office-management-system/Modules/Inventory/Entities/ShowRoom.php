<?php

namespace Modules\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Account\Entities\ChartAccount;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductHistory;
use Modules\Purchase\Entities\CostOfGoodHistory;
use Modules\Purchase\Entities\PurchaseOrder;
use Modules\Purchase\Entities\SuggestLists;
use Modules\Quotation\Entities\Quotation;
use Modules\Sale\Entities\Sale;

class ShowRoom extends Model
{
    protected $table = 'show_rooms';

    protected $guarded = ['id'];

    protected $appends = ['TotalStock'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function contact()
    {
        return $this->morphOne(ChartAccount::class, 'contactable');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchases()
    {
        return $this->morphMany(PurchaseOrder::class, 'purchasable');
    }

    public function sends()
    {
        return $this->morphMany(StockTransfer::class, 'sendable');
    }

    public function receives()
    {
        return $this->morphMany(StockTransfer::class, 'receivable');
    }

    public function sales()
    {
        return $this->morphMany(Sale::class, 'saleable');
    }

    public function stores()
    {
        return $this->morphMany(CostOfGoodHistory::class, 'storeable');
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }

    public function items()
    {
        return $this->morphMany(ProductHistory::class, 'itemable');
    }

    public function quotations()
    {
        return $this->morphMany(Quotation::class, 'quotationable');
    }

    public function stocks()
    {
        return $this->morphMany(StockReport::class, 'houseable');
    }

    public function suggestLists()
    {
        return $this->morphMany(SuggestLists::class, 'houseable');
    }

    public function adjusts()
    {
        return $this->morphMany(StockAdjustment::class, 'adjustable');
    }

    public static function boot(): void
    {
        parent::boot();
        static::saving(function ($warehouse): void {
            $warehouse->created_by = Auth::user()->id ?? null;
        });

        static::updating(function ($warehouse): void {
            $warehouse->updated_by = Auth::user()->id ?? null;
        });
    }

    public function getAccountsAttribute()
    {
        $sales = $this->sales;
        $payable_amount = $sales->sum('payable_amount');

        $paid_amount = 0;
        $sales_return_amount = 0;
        $total_amount = 0;

        foreach ($sales as $sale) {
            $paid_amount += $sale->payments->sum('amount');
            $sales_return_amount += $sale->items->sum('return_amount');
        }

        $total_amount = $payable_amount + $this->opening_balance - $sales_return_amount;
        $due_amount = $total_amount - $paid_amount;

        $accounts['total'] = $total_amount;
        $accounts['paid'] = $paid_amount;
        $accounts['due'] = $due_amount;
        $accounts['total_invoice'] = count($sales);
        $accounts['due_invoice'] = count($sales->where('is_approved', 0));

        return $accounts;
    }

    public function getTotalStockAttribute()
    {
        return $this->stocks->sum('stock');
    }
}
