<?php

namespace App\Models\Shop;

use App\Models\Traits\Filterable;
use App\Models\Traits\HasMedia\HasMedia;
use App\Models\Traits\HasMedia\HasMediaTrait;
use App\Models\Traits\Metatagable;
use App\Models\Traits\Navigable;
use App\Traits\UrlAliasGenerator;
use Fomvasss\Taxonomy\Models\Traits\HasTaxonomies;
use Fomvasss\UrlAliases\Traits\UrlAliasable;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\Models\Media;

class Product extends Model implements HasMedia
{
    use Filterable;
    use HasMediaTrait;
    use HasTaxonomies;
    use Metatagable;
    use Navigable;
    use Sortable;
    use UrlAliasable;
    use UrlAliasGenerator;

    /** @var int */
    const TYPE_PRODUCT = 1;

    /** @var int */
    const TYPE_COLLECTION = 2;

    /** @var array */
    protected $guarded = ['id'];

    /** @var array */
    protected $mediaFieldsMultiple = ['images'];

    /** @var array */
    protected $mediaFieldsSingle = ['specification'];

    /** @var array */
    protected $casts = [
        'data' => 'array',
    ];

    /** @var array */
    protected $sortable = [
        'id', 'name', 'price', 'rating', 'created_at', 'product_group_id',
    ];

    /** @var array */
    protected $filterable = [
        'sku' => 'like',
        'name' => 'like',
        'price' => 'between',
        'publish' => 'in',
        'created_at' => 'between_date',
    ];

//    public function registerMediaCollections(): void
//    {
//        $this->addMediaCollection('images');
//        $this->addMediaCollection('specification');
//    }

    /**
     * Кеширование результата метода getCalculatePrice().
     *
     * @var null
     */
    private $cacheCalculatePrice;

    /**
     * Attributes values.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function values()
    {
        return $this->belongsToMany(Value::class)->withPivot('price');
    }

    /**
     * Reviews for product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    /**
     * Taxonomy term - main category.
     *
     * @return mixed
     */
    public function txCategory()
    {
        return $this->term('category_id', 'id')
            ->where('vocabulary', 'product_categories');
    }

    /**
     * Taxonomy terms - categories.
     *
     * @return mixed
     */
    public function txCategories()
    {
        return $this->termsByVocabulary('product_categories');
    }

    /**
     * Get group product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sales()
    {
        return $this->morphToMany(Sale::class, 'model', 'saleables');
    }

    public function salesIsPublish()
    {
        return $this->morphToMany(Sale::class, 'model', 'saleables')->isPublish();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    // TODO: check relation
    //public function collections()
    //{
    //    return $this->belongsToMany(self::class, 'product_collection', 'collection_id', 'product_id')
    //        ->where('type', '<>', self::TYPE_COLLECTION);
    //}

    /**
     * WARNING: This is not relation!!!
     * Акции скидки, для главной категории товара.
     *
     * @return mixed
     */
    public function salesThroughCategory()
    {
        return $this->txCategory->sales()->isPublish();
    }

    public function salesThroughCategoryIsPublish()
    {
        return $this->txCategory->salesIsPublish;
    }

    /**
     * All product variants from self groups.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function variants()
    {
        return $this->group->products();
        //return $this->hasManyThrough(Product::class, ProductGroup::class);
    }

    /**
     * Все атрибуты по главной категории и ее предков.
     *
     * @return mixed
     */
    public function attrsAncestorsCategories()
    {
        $txCategory = $this->group && $this->group->product && $this->group->product->txCategory && ($this->group->product->locale === $this->locale) ? $this->group->product->txCategory : $this->txCategory;

        return $txCategory->ancestors->push($txCategory)->map(function ($term) {
            return $term->attrs;
        })->flatten()->unique('id');
    }

    /**
     * Атрибуты обьема/веса групы товаров.
     *
     * @return mixed
     */
    public function attrsGroups()
    {
        $productGroups = $this->group->products()->where('locale', $this->locale)->with('values.attribute')->get();

        $res = [];
        foreach ($productGroups as $prod) {
            $res[$prod->id] = $prod->values->where('attribute.purpose', Attribute::PURPOSE_CARD)->where('attribute.locale', $this->locale)->first()->toArray();
            $res[$prod->id]['link'] = $prod;
        }

        return $res;

//        return $txCategory->ancestors->push($txCategory)->map(function ($term) {
//            return $term->attrs;
//        })->flatten()->unique('id');
    }

    //        $productGroups  = $product->group->products()->with('values.attribute')->get();
//        $res = [];
//        foreach ($productGroups as $prod)
//        {
//            $res[$prod->id] = $prod->values->where('attribute.purpose', Attribute::PURPOSE_CARD)->first();
//        }

    /**
     * Получить установленные (через значения атрибутов) уникальные атрибуты товара.
     *
     * @return mixed
     */
    public function getUniqueAttrs()
    {
        return $this->values->map(function ($value) {
            return $value->attribute;
        })->flatten(1)->unique('id');
    }

    /**
     * @return int
     */
    public function getReviewsRating()
    {
        return $this->reviews
            ->where('status', 1)
            ->avg('rating');
    }

    public function scopeWithBase($query)
    {
        return $query->with('media', 'urlAlias', 'group', 'reviews', 'group.product.media', 'txCategory', 'salesIsPublish', 'txCategory.salesIsPublish');
    }

    public function scopeIsPublish($query)
    {
        return $query->where('publish', 1);
    }

    /**
     * Строка значений указанных атрибутов для товара.
     *
     * @return string
     */
    public function valuesStr(string $delimiter = ', ')
    {
        return $this->values->whereIn('attribute_id', variable('product_values_attributes_str', [1])) // TODO must by dynamic auto
            ->map(function ($v) {
                return $v->value . $v->suffix;
            })->implode($delimiter);
    }

    /**
     * Товар-бестселлер.
     *
     * @return bool
     */
    public function isBestseller()
    {
        return $this->rating > variable('products_is_bestseller_rating', 100);
    }

    /**
     * Фасентые фильтры.
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeFacetFilter($query, array $attributes = [])
    {
        $categoriesSlugs = $attributes['category'] ?? [];
        $query->when(count($categoriesSlugs), function ($q) use ($categoriesSlugs): void {
            $q->whereHas('terms', function ($terms) use ($categoriesSlugs): void {
                $terms->whereIn('system_name', $categoriesSlugs);
            });
        });
        unset($attributes['category']);

        foreach ($attributes as $attribute => $valuesSlugs) {
            $query->when(count($valuesSlugs), function ($q) use ($valuesSlugs, $attribute): void {
                $q->whereHas('values', function ($values) use ($valuesSlugs, $attribute): void {
                    $values->whereIn('slug', $valuesSlugs)->whereHas('attribute', function ($a) use ($attribute): void {
                        $a->where('slug', $attribute);
                    });
                });
            });
        }

        return $query;
    }

    /**
     * Получить массив цен:
     * со скидкой, сумма скидки, акция,...
     */
    public function calculatePrice()
    {
        //if ($this->{'prices'.$this->id}) {
        //    return $this->{'prices'.$this->id};
        //}

        $prices[] = [
            'discount' => 0,
            'sale' => null,
            'price' => $this->price,
            'price_old' => 0,
        ];

        // Сумма скидки относительно заданой старой цене - не акция!
        if ($this->price_old > 0) {
            $prices[] = [
                'discount' => $this->price_old - $this->price,
                'sale' => null,
                'price' => $this->price,
                'price_old' => $this->price_old,
            ];
        }

        // Акции которые дают скидку на текущий товар (типа акции - скидка на тововар/категорию)
        $sales = $this->salesIsPublish
            ->merge($this->salesThroughCategory)->where('type', Sale::TYPE_PRODUCT);

        // Тип скидки - Сумма скидки от акции с указаным процентом скидки
        if ($salesDiscountTypePercent = $sales->where('discount_type', Sale::DISCOUNT_TYPE_PERCENT)->sortByDesc('discount')->first()) {
            $discount = $salesDiscountTypePercent->discount * $this->price / 100;
            $prices[] = [
                'discount' => $discount,
                'sale' => $salesDiscountTypePercent,
                'price' => $this->price,
                'price_old' => $this->price + $discount,
            ];
        }

        // Тип скидки - Сумма скидки от акции с указаной фиксированой суммой скидки
        if ($salesDiscountTypeSum = $sales->where('discount_type', Sale::DISCOUNT_TYPE_SUM)->sortByDesc('discount')->first()) {
            $discount = $salesDiscountTypeSum->discount;
            $prices[] = [
                'discount' => $discount,
                'sale' => $salesDiscountTypeSum,
                'price' => $this->price,
                'price_old' => $this->price + $discount,
            ];
        }

        // Ищем максимальную суму скидки
        $max = $prices[0];
        foreach ($prices as $price) {
            if ($price['discount'] > $max['discount']) {
                $max = $price;
            }
        }
        $this->{'prices' . $this->id} = $max;

        return $max;
    }

    /**
     * Получить массив цен:
     * со скидкой, сумма скидки, акция,...
     */
    public function getCalculatePrice(?string $field = null)
    {
        $cart = session()->get('cart');
//        dd(isset($cart[$this->id]) ? $cart[$this->id]["price"] : $this->price);
//        if(isset($cart[$this->id]))
//        {}
//        dd($cart);
        if (isset($this->cacheCalculatePrice)) {
            $max = $this->cacheCalculatePrice;
        } else {
            $prices[] = [
                'discount' => 0,
                'sale' => null,
                //                'price' => $this->price,
                'price' => isset($cart[$this->id]) ? $cart[$this->id]['price'] : $this->price,
                'price_old' => 0,
            ];

            // Сумма скидки относительно заданой старой цене - не акция!
            if ($this->price_old > 0) {
                $prices[] = [
                    'discount' => $this->price_old - $this->price,
                    'sale' => null,
                    //                    'price' => $this->price,
                    'price' => isset($cart[$this->id]) ? $cart[$this->id]['price'] : $this->price,
                    'price_old' => $this->price_old,
                ];
            }

            // Акции которые дают скидку на текущий товар (типа акции - скидка на тововар/категорию)
            $sales = $this->salesIsPublish->merge($this->salesThroughCategoryIsPublish())->where('type', Sale::TYPE_PRODUCT);

            // Тип скидки - Сумма скидки от акции с указаным процентом скидки
            if ($salesDiscountTypePercent = $sales->where('discount_type', Sale::DISCOUNT_TYPE_PERCENT)->sortByDesc('discount')->first()) {
                $discount = $salesDiscountTypePercent->discount * $this->price / 100;
                $prices[] = [
                    'discount' => $discount,
                    'sale' => $salesDiscountTypePercent,
                    'price' => (isset($cart[$this->id]) ? $cart[$this->id]['price'] : $this->price) - $discount,
                    //                    'price' => $this->price - $discount,
                    'price_old' => $this->price,
                ];
            }

            // Тип скидки - Сумма скидки от акции с указаной фиксированой суммой скидки
            if ($salesDiscountTypeSum = $sales->where('discount_type', Sale::DISCOUNT_TYPE_SUM)->sortByDesc('discount')->first()) {
                $discount = $salesDiscountTypeSum->discount;
                $prices[] = [
                    'discount' => $discount,
                    'sale' => $salesDiscountTypeSum,
                    'price' => (isset($cart[$this->id]) ? $cart[$this->id]['price'] : $this->price) - $discount,
                    //                    'price' => $this->price - $discount,
                    'price_old' => $this->price,
                ];
            }

            // Ищем цену с максимальной суммой скидки
            $max = $prices[0];
            foreach ($prices as $price) {
                if ($price['discount'] > $max['discount']) {
                    $max = $price;
                }
            }

            $this->cacheCalculatePrice = $max;
        }

        if ($field) {
            return $max[$field];
        }

        return $max;
    }

    /**
     * Изображение товара (или главного товара группы).
     */
    public function getFirstMediaUrl(string $collectionName = 'default', string $conversionName = '', string $defaultUrl = ''): string
    {
        $media = $this->getFirstMedia($collectionName) ?: optional($this->group->product)->getFirstMedia($collectionName);

        return $media ? $media->getUrl($conversionName) : $defaultUrl;
    }

    /**
     * In that method you can set own algorithm
     * for calculate product rating. Enjoy!
     */
    public function calculateRating(): int
    {
        return $this->orders->count();
    }

    public function generateUrlAlias(?string $rawAliasPath = null): string
    {
        if (empty($rawAliasPath)) {
            if ($this->txCategory) {
                $rawAliasPath = $this->getRawPathForNestedEntity($this->txCategory);
            }
            $rawAliasPath .= '/' . str_replace('/', '-', $this->name);
        }

        return trim($this->getUniqueAliasedPath($this, $rawAliasPath), '/');
    }

    public function generateUrlSource(): string
    {
        return trim(route('product.show', $this, false), '/');
    }

    public function customMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->format('jpg')->quality($this->getMediaQuality())
            ->fit('fill', 235, 216)
            ->performOnCollections('images');
        //->fit('crop', 235, 216);

        $this->addMediaConversion('card-product')
            ->format('jpg')->quality($this->getMediaQuality())
            ->fit('fill', 471, 447)
            ->performOnCollections('images');

        $this->addMediaConversion('xml-rozetka')
            ->format('jpg')->quality($this->getMediaQuality())
            ->fit('fill', 850, 850)
            ->performOnCollections('images');

        $this->addMediaConversion('cart-page')
            ->format('jpg')->quality($this->getMediaQuality())
            ->fit('fill', 235, 216)
            ->performOnCollections('images');
        //->fit('crop', 235, 216);
    }
}
