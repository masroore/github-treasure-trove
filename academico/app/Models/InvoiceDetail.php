<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\InvoiceDetail.
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $product_name
 * @property null|string $product_code
 * @property null|int $product_id
 * @property null|string $product_type
 * @property int $quantity
 * @property string $price
 * @property string $tax_rate
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|\Illuminate\Support\Carbon $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property mixed $price_with_currency
 * @property mixed $total_price
 * @property \App\Models\Invoice $invoice
 * @property Eloquent|Model $product
 *
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail newQuery()
 * @method static \Illuminate\Database\Query\Builder|InvoiceDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereProductCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|InvoiceDetail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|InvoiceDetail withoutTrashed()
 * @mixin \Eloquent
 */
class InvoiceDetail extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected static $logUnguarded = true;

    protected $appends = ['price_with_currency'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function product()
    {
        return $this->morphTo();
    }

    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function getFinalPriceAttribute($value)
    {
        return $value ? $value / 100 : $this->price;
    }

    public function getTotalPriceAttribute($value)
    {
        return ($value * $this->quantity) / 100;
    }

    public function getPriceWithCurrencyAttribute()
    {
        if (config('app.currency_position') === 'before') {
            return config('app.currency_symbol') . ' ' . $this->price;
        }

        return $this->price . ' ' . config('app.currency_symbol');
    }

    /*
|--------------------------------------------------------------------------
| MUTATORS
|--------------------------------------------------------------------------
*/

    public function setPriceAttribute($value): void
    {
        $this->attributes['price'] = $value * 100;
    }
}
