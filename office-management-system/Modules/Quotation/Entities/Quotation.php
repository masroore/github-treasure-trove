<?php

namespace Modules\Quotation\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Contact\Entities\ContactModel;
use Modules\Inventory\Entities\ShowRoom;
use Modules\Product\Entities\ProductHistory;
use Modules\Purchase\Entities\ProductItemDetail;
use Modules\Setup\Entities\IntroPrefix;

class Quotation extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['document' => 'array'];

    public function showroom()
    {
        return $this->belongsTo(ShowRoom::class, 'show_room_id');
    }

    public function houses()
    {
        return $this->morphMany(ProductHistory::class, 'houseable');
    }

    public function quotationable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updator()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function customer()
    {
        return $this->belongsTo(ContactModel::class)->customer();
    }

    public function items()
    {
        return $this->morphMany(ProductItemDetail::class, 'itemable');
    }

    public function getItemIdsAttribute()
    {
        return $this->items->pluck('product_id')->toArray();
    }

    public static function boot(): void
    {
        parent::boot();

        static::created(function ($model): void {
            $model->invoice_no = IntroPrefix::find(4)->prefix . '-' . date('y') . date('m') . Auth::id() . $model->id;
            $model->created_by = Auth::user()->id ?? null;
            $model->save();
        });

        static::updating(function ($model): void {
            $model->updated_by = Auth::user()->id ?? null;
        });
    }
}
