<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Invoice.
 *
 * @property int $id
 * @property null|int $invoice_number
 * @property null|int $invoice_type_id
 * @property null|string $client_name
 * @property null|string $client_idnumber
 * @property null|string $client_address
 * @property null|string $client_email
 * @property null|string $client_phone
 * @property null|string $total_price
 * @property int $company_id
 * @property null|string $receipt_number
 * @property null|\Illuminate\Support\Carbon $date
 * @property null|\Illuminate\Support\Carbon $created_at
 * @property null|\Illuminate\Support\Carbon $updated_at
 * @property null|string $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activities
 * @property null|int $activities_count
 * @property \App\Models\Comment[]|\Illuminate\Database\Eloquent\Collection $comments
 * @property null|int $comments_count
 * @property \App\Models\Enrollment[]|\Illuminate\Database\Eloquent\Collection $enrollments
 * @property null|int $enrollments_count
 * @property mixed $formatted_date
 * @property mixed $formatted_number
 * @property mixed $invoice_reference
 * @property string $invoice_series
 * @property mixed $total_price_with_currency
 * @property \App\Models\InvoiceDetail[]|\Illuminate\Database\Eloquent\Collection $invoiceDetails
 * @property null|int $invoice_details_count
 * @property null|\App\Models\InvoiceType $invoiceType
 * @property \App\Models\Payment[]|\Illuminate\Database\Eloquent\Collection $payments
 * @property null|int $payments_count
 * @property \App\Models\InvoiceDetail[]|\Illuminate\Database\Eloquent\Collection $products
 * @property null|int $products_count
 * @property \App\Models\ScheduledPayment[]|\Illuminate\Database\Eloquent\Collection $scheduledPayments
 * @property null|int $scheduled_payments_count
 * @property \App\Models\InvoiceDetail[]|\Illuminate\Database\Eloquent\Collection $taxes
 * @property null|int $taxes_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientIdnumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereReceiptNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use CrudTrait;
    use LogsActivity;

    protected $guarded = ['id'];

    protected static $logUnguarded = true;

    protected $appends = ['total_price_with_currency', 'formatted_date'];

    protected $casts = [
        'date' => 'date',
    ];

    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class)->orderByRaw("CASE WHEN product_type like '%Enrollment' THEN 10 WHEN product_type like '%Fee' THEN 5 ELSE 0 END desc");
    }

    public function products()
    {
        return $this->hasMany(InvoiceDetail::class)->whereIn('product_type', [Enrollment::class, Fee::class]);
    }

    public function taxes()
    {
        return $this->hasMany(InvoiceDetail::class)->where('product_type', Tax::class);
    }

    public function scheduledPayments()
    {
        return $this->belongsToMany(ScheduledPayment::class, 'enrollment_invoice', 'invoice_id', 'scheduled_payment_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paidTotal()
    {
        return $this->payments->sum('value');
    }

    public function enrollments()
    {
        return $this->belongsToMany(Enrollment::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function invoiceType()
    {
        return $this->belongsTo(InvoiceType::class);
    }

    public function setNumber(): void
    {
        // retrieve the last entry for the same type / year, and increment
        $count = self::whereInvoiceTypeId($this->invoice_type_id)->whereYear('created_at', $this->created_at->year)->orderByDesc('invoice_number')->first()->invoice_number;

        $this->update(['invoice_number' => $count + 1]);
    }

    public function getInvoiceReferenceAttribute()
    {
        if (config('invoicing.invoice_numbering') === 'manual') {
            return $this->receipt_number;
        }

        return $this->invoiceType->name . $this->created_at->format('y') . '-' . $this->invoice_number;
    }

    public function getInvoiceSeriesAttribute(): string
    {
        return $this->invoiceType->name . $this->created_at->format('y');
    }

    public function getTotalPriceWithCurrencyAttribute()
    {
        if (config('app.currency_position') === 'before') {
            return config('app.currency_symbol') . ' ' . $this->total_price;
        }

        return $this->total_price . ' ' . config('app.currency_symbol');
    }

    public function getTotalPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalPriceAttribute($value): void
    {
        $this->attributes['total_price'] = $value * 100;
    }

    public function getFormattedNumberAttribute()
    {
        if (config('invoicing.invoice_numbering') === 'manual') {
            return $this->receipt_number;
        }

        return 'FC' . $this->receipt_number;
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->locale(app()->getLocale())->isoFormat('Do MMMM YYYY');
    }
}
