<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'parent_branch_id',
        'store_logo',
        'store_name',
        'whatsapp_num',
        'business_url',
        'industry_id',
        'email',
        'website',
        'street_address',
        'latitude',
        'longitude',
        'country',
        'city',
        'state',
        'postal_code',
        'bank_phone',
        'area',
        'is_online',
        'phone_number',
        'mobile_number',
        'ntn_num',
        'acc_number',
        'iban_number',
        'payment_method',
        'description',
        'cash_on_delivery',
        'store_service_charges',
        'service_charges',
        'currency',
        'shipping_percentage_type',
        'shipping_percentage',
        'applicable_range',
        'delivery_hours',
        'delivery_minutes',
        'delivery_rangeIndex',
        'delivery_radius',
        'disount_type',
        'discount_amount',
        'service_option',
        'free_trial_start_date',
        'qrcode_img',
        'auto_subscription',
        'subscription_canceled_status',
        'subscription_canceled_date',
        'subscription_restart_date',
        'orders_accept_status',
        'status',
    ];

    protected $hidden = ['pivot'];

    public function getBusinessUrlAttribute()
    {
        return $this->attributes['business_url'] ? $this->attributes['business_url'] . '.whatspays.com' : null;
    }

    public function getWhatsappNumAttribute()
    {
        return $this->attributes['whatsapp_num'] ? '+' . Str::remove('+', $this->attributes['whatsapp_num']) : null;
    }

    /*public function getDeliveryFeeAttribute() {

        $fee = 'Free Delivery';
        if($this->attributes['delivery_fee'] > 0) {
            switch ($this->attributes['shipping_percentage_type']) {
                case 'flat':
                    $fee = $this->attributes['currency'] . ' ' . $this->attributes['delivery_fee'] . ' Delivery fee';
                    break;

                case 'percentage':
                    $fee = $this->attributes['delivery_fee']. '% Delivery fee';
                    break;
            }
        }

        return $fee;
    }*/

    public function getStoreTimingsAttribute()
    {
        return json_decode($this->attributes['store_timings']);
    }

    public function getPaymentMethodAttribute()
    {
        return ('enable' == $this->attributes['payment_method']) ? 'Accept Cash & Online Payment' : 'Accept Online Payment';
    }

    public function getDeliveryTimeAttribute()
    {
        $delivery = '';
        $delivery_hours = $this->attributes['delivery_hours'];
        $delivery_minutes = $this->attributes['delivery_minutes'];
        $delivery_days = \count((array) $this->attributes['store_timings']);
        $delivery_timings = getDeliveryTimings($delivery_hours, $delivery_minutes, $delivery_days);

        if ($delivery_timings) {
            $delivery = $delivery_timings['timing'] . $delivery_timings['type'];
        }

        return $delivery;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industries::class, 'industry_id');
    }

    public function shipping()
    {
        return $this->hasMany(Shipping::class);
    }

    public function shippingcompanies()
    {
        return $this->hasMany(ShippingCompanies::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function branches()
    {
        return $this->hasMany(self::class, 'parent_branch_id');
    }

    public function categories()
    {
//        dd($this->hasMany(Categories::class,'store_id')->paginate(8));
        return $this->hasMany(Categories::class, 'store_id');
//        return $this->hasMany(Categories::class,'store_id')->with('products');
//        return $this->hasManyThrough(Categories::class, Products::class,'store_id','category_id','id');
//        return $this->belongsToMany(Categories::class,'products','store_id','category_id');
//        return $this->hasMany(Categories::class,'store_id')->join('products' , 'products.category_id', '=', 'categories.id')
////            ->select([
////                'products.*',
////                'categories.*'
////            ]);
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'store_id');
    }

    public function categoryPaginate()
    {
        return $this->categories()->paginate(2);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function slug()
    {
        return $this->morphOne(Slug::class, 'slugeable', 'slugable_type', 'slugable_id');
    }

    public function brands()
    {
        return $this->belongsToMany(Brands::class, 'store_brands', 'store_id', 'brand_id')
            ->select('store_brands.id', 'brands.id as brand_id', 'brands.name', 'store_brands.status');
    }

    /**
     * Get if store is favorite.
     */
    public function favorite()
    {
        return $this->morphOne(Favorites::class, 'favorable');
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

    public function notifiable()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
