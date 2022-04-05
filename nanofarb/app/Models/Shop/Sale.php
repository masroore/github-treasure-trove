<?php

namespace App\Models\Shop;

use App\Models\Taxonomy\Term;
use App\Models\Traits\Filterable;
use App\Models\Traits\HasMedia\HasMedia;
use App\Models\Traits\HasMedia\HasMediaTrait;
use App\Models\Traits\Metatagable;
use App\Models\Traits\Navigable;
use App\Traits\UrlAliasGenerator;
use Fomvasss\UrlAliases\Traits\UrlAliasable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\Models\Media;

class Sale extends Model implements HasMedia
{
    use Filterable;
    use HasMediaTrait;
    use Metatagable;
    use Navigable;
    use Sortable;
    use UrlAliasable;
    use UrlAliasGenerator;

    /**
     * Тип акции.
     * Тип способа (условие) начисления акционной скидки.
     */
    const TYPE_PRODUCT = 1;
    const TYPE_PROM_CODE_PRODUCT = 2;
    const TYPE_FREE_SHIPPING_CONDITIONS = 3;
    const TYPE_PROM_CODE_FREE_ORDER = 4;
    const TYPE_PROM_CODE_DISCOUNT_SUM_ORDER = 5;
    const TYPE_PROM_CODE_PRODUCT_PRESENT = 6;

    /**
     * Тип скидки.
     */
    /** @var int Процент */
    const DISCOUNT_TYPE_PERCENT = 1;
    /** @var int Сумма */
    const DISCOUNT_TYPE_SUM = 2;

    /** @var array */
    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    /** @var array */
    protected $dates = [
        'start_at', 'end_at',
    ];

    /** @var array */
    protected $mediaFieldsSingle = ['image'];

    //protected $mediaFieldsMultiple = ['image'];

    /** @var array */
    protected $sortable = [
        'id', 'name', 'discount', 'created_at',
    ];

    /** @var array */
    public static $types = [
        self::TYPE_PRODUCT => 'Скидка на заданные товары/категории товаров (старая/новая цена)',
        //self::TYPE_PROM_CODE_PRODUCT => 'Скидка на заданные товары/категории товаров по промокоду',
        self::TYPE_FREE_SHIPPING_CONDITIONS => 'Бессплатная доставка',
        self::TYPE_PROM_CODE_FREE_ORDER => 'Бессплатная доставка по промокоду',
        self::TYPE_PROM_CODE_DISCOUNT_SUM_ORDER => 'Скидка на сумму товаров в заказе по промокоду',
        //self::TYPE_PROM_CODE_PRODUCT_PRESENT => 'Товар в подарок по промокоду',
    ];

    /** @var array */
    protected $filterable = [
        'name' => 'like',
        'discount' => 'between',
        'publish' => 'in',
        'type' => 'in',
        'created_at' => 'between_date',
        'start_at' => 'between_date',
        'end_at' => 'between_date',
    ];

    public function promoCodes()
    {
        return $this->hasMany(SalePromoCode::class, 'sale_id')->orderByDesc('id');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'model', 'saleables');
    }

    public function terms()
    {
        return $this->morphedByMany(Term::class, 'model', 'saleables');
    }

    public function getDiscountSumAttribute()
    {
        return $this->discount_type === self::DISCOUNT_TYPE_PERCENT ?
            $this->discount :
            $this->discount / 100;
    }

    public function scopeIsPublish($query)
    {
        return $query->where('publish', 1)->where(function ($sales): void {
            $sales->where('dateless', 1)->orWhere(function ($sales2): void {
                $sales2->whereDate('start_at', '<', \Carbon\Carbon::now()->toDateString())->whereDate('end_at', '>', \Carbon\Carbon::now()->toDateString());
            });
        });
    }

    /**
     * @return string
     */
    public function generateUrlAlias(?string $alias = null)
    {
        $name = str_replace('/', '-', $this->name);

        return $this->getUniqueAliasedPath($this, $alias ?? request('url_alias', 'sales/' . $name));
    }

    /**
     * @return string
     */
    public function generateUrlSource()
    {
        return trim(route('sale.show', $this, false), '/');
    }

    /**
     * @param null|\App\Models\Shop\Media $media
     */
    public function customMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->format('jpg')->quality($this->getMediaQuality())
            ->fit('crop', 331, 191);

        $this->addMediaConversion('long')
            ->quality($this->getMediaQuality())
            ->fit('stretch', 1925, 400);
    }
}
