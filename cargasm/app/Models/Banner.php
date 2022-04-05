<?php

namespace App\Models;

use App\Models\Traits\HasLang;
use App\Models\Traits\HasMediaTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class Banner extends Model implements HasMedia
{
    use HasLang;
    use HasMediaTrait;

    protected $guarded = ['id'];

    public $timestamps = false;

    public $mediaSingleCollections = ['photo'];

    public const ACTIVE = true;
    public const NOT_ACTIVE = false;

    protected $attributes = [
        'weight' => 1000,
    ];

    public function isActive(): bool
    {
        return $this->is_active === self::ACTIVE;
    }

    public function isNotActive(): bool
    {
        return $this->is_active === self::NOT_ACTIVE;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('weight', function (Builder $builder): void {
            $builder->orderBy('weight', 'asc')
                ->orderBy('id', 'asc');
        });
    }

    public static function regionList()
    {
        return [
            'top' => 'Top',
            'center' => 'Center',
            'shop_banners' => 'Shop banners',
        ];
    }

    public static function subRegionsList()
    {
        $a = [
            'shop_banners_1_559x351',
            'shop_banners_2_267x351',
            'shop_banners_3_267x351',
            'shop_banners_4_267x351',
            'shop_banners_5_559x351',
            'shop_banners_6_267x351',
        ];

        return array_combine($a, $a);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 100, 100)
            ->performOnCollections('photo')
            ->nonQueued();
    }
}
