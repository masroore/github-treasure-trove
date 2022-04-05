<?php

namespace App\Models\Shop;

use App\Models\Traits\Filterable;
use App\Models\User;
use Currency;
use Fomvasss\Taxonomy\Models\Traits\HasTaxonomies;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Filterable;
    use HasTaxonomies;

    /** @var int */
    const TYPE_ORDER = 1;

    /** @var int */
    const TYPE_CART = 2;

    /** @var array */
    protected $guarded = ['id'];

    /** @var array */
    protected $casts = [
        'data' => 'array',
    ];

    /** @var array */
    protected $dates = ['ordered_at'];

    /** @var array */
    protected $filterable = [
        'number' => 'like',
        'name' => 'like',
        'price' => 'between',
        'status' => 'in',
        'payment_status' => 'in',
        'ordered_at' => 'between_date',
    ];

    public static $deliveryMethods = [
        '' => '---',
        'novaposhta' => 'Нова почта',
        'pickup' => 'Самовывоз с магазина',
        'courier' => 'Доставка курьером',
    ];

    public static $dataFields = [
        // 'category_id' => 'Направление',
        'number' => 'Номер заказа',
        'title' => 'Заголовок (Заказ №)',
        'ordered_at' => 'Дата оформления',
        'payment_status' => 'Статус оплаты',
        'sum' => 'Сумма заказа',
        'discount' => 'Сумма скидки',
        'delivery_price' => 'Стоимость доставки',
        'promocode' => 'Промокод',
        'payment_method' => 'Метод оплаты',
        'delivery_method' => 'Метод доставки',
        'address' => 'Адрес доставки заказа',
        'city' => 'Город',
        'pvz' => 'Отделение',
        'sales' => 'Акции + ID',
    ];

    public static function getPaymentMethods()
    {
        return [
            'upon_receipt' => trans('site.Оплата при получении'),
            'prepaid_card' => trans('site.Предоплата на карту'),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['price', 'currency', 'quantity', 'value_id']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function value()
    {
        return $this->hasOne(Value::class, 'id', 'value_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function previous()
    {
        $sortField = $this->getKeyName();

        return static::where($sortField, '<', $this->getKey())
            ->where('type', self::TYPE_ORDER)->orderByDesc($sortField)
            ->first();
    }

    public function next()
    {
        $sortField = $this->getKeyName();

        return static::where($sortField, '>', $this->getKey())
            ->where('type', self::TYPE_ORDER)->orderBy($sortField)
            ->first();
    }

    /**
     * @return mixed
     */
    public function txStatus()
    {
        return $this->term('status', 'system_name')
            ->where('vocabulary', 'order_statuses');
    }

    /**
     * @return mixed
     */
    public function txPaymentStatus()
    {
        return $this->term('payment_status', 'system_name')
            ->where('vocabulary', 'payment_statuses');
    }

    public function getStatusStr()
    {
        if ($this->txStatus) {
            return trans('site.' . $this->txStatus->name);
        }

        return '-';
    }

    public function getPaymentStatusStr()
    {
        if ($this->txPaymentStatus) {
            return trans('site.' . $this->txPaymentStatus->name);
        }

        return '-';
    }

    public function getDeliveryAddressStr()
    {
        $items = [
            $this->data['delivery']['name'] ?? '',
            $this->data['delivery']['phone'] ?? '',
            $this->data['delivery']['email'] ?? '',
            $this->data['delivery']['region'] ?? '',
            $this->data['delivery']['city'] ?? '',
            $this->data['delivery']['address'] ?? '',
            $this->data['delivery']['pvz'] ?? '',
            $this->data['delivery']['zip_code'] ?? '',
        ];

        return implode(', ', array_filter($items, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        }));
    }

    public function getPaymentMethodStr()
    {
        $paymentMethodKeys = self::getPaymentMethods();

        if (isset($this->data['payment']['method'])) {
            if (isset($paymentMethodKeys[$this->data['payment']['method']])) {
                return $paymentMethodKeys[$this->data['payment']['method']];
            }
        }

        return '---';
    }

    public function getDeliveryMethodStr()
    {
        if (isset($this->data['delivery']['method'])) {
            if (isset(static::$deliveryMethods[$this->data['delivery']['method']])) {
                return trans('site.' . static::$deliveryMethods[$this->data['delivery']['method']]);
            }
        }

        return '---';

        //return static::$deliveryMethods[$this->data['delivery']['method'] ?? ''] ?? '---';
    }

    /**
     * @param $value
     *
     * @return int|mixed
     */
    public function getNumberAttribute($value)
    {
        // TODO
        return $value ?? $this->id;
    }

    public function getPriceAttribute()
    {
        // TODO
        return $this->products->map(function ($p) {
            return $p->pivot->price * $p->pivot->quantity;
        })->sum();
    }

    public function getFinalSumStr($formated = true)
    {
        $res = $this->price + ($this->data['purchase']['delivery'] ?? 0) - ($this->data['purchase']['discount'] ?? 0);

        if ($formated) {
            return Currency::format($res);
        }

        return $res;
    }

    public function getCalculateDiscount(?string $type = null)
    {
        if ($type) {
            return $this->data['purchase'][$type] ?? 0;
        }

        return ($this->data['purchase']['discount'] ?? 0) + ($this->data['purchase']['discount_products'] ?? 0);
    }
}
