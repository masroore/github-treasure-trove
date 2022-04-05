<?php

namespace App\Models\Shop;

use Fomvasss\Taxonomy\Models\Traits\HasTaxonomies;
use Fomvasss\UrlAliases\Traits\LocaleScopes;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasTaxonomies;
    use LocaleScopes;

    const DATA_TYPE_STRING = 1;

    const DATA_TYPE_NUMBER = 2;

    /**
     * Show only product card.
     * Has single value.
     */
    const PURPOSE_CARD = 1;

    /**
     * Show only products facet filter.
     * Has multiple values.
     */
    const PURPOSE_FACET = 2;

    /**
     * Show in product card & products facet filter.
     * Has single value.
     */
    const PURPOSE_COMBINED = 3;

    /**
     * Tinting.
     */
    const PURPOSE_TINTING_INTERIOR = 4;
    const PURPOSE_TINTING_FACADE = 5;

    /**
     * @var array
     */
    public static $purposes = [
        self::PURPOSE_FACET => 'Для фасетных фильтров',
        self::PURPOSE_CARD => 'Для переключения вариантов',
        self::PURPOSE_COMBINED => 'Комбинированные',
        self::PURPOSE_TINTING_INTERIOR => 'Колеровка - интерьерные цвета',
        self::PURPOSE_TINTING_FACADE => 'Колеровка - фасадные цвета',
    ];

    public $timestamps = false;

    protected $with = ['values'];

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(Value::class);
    }

    /**
     * Значение атрибутов которые "Не скрывать в фильтре, при отсутствии товаров".
     *
     * @return string
     */
    public function getShowIfEmptyFilterAttribute()
    {
        return $this->data['show_if_empty_filter'] ?? '0';
    }
}
