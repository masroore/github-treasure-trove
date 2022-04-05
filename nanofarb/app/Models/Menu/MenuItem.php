<?php

namespace App\Models\Menu;

use App\Models\Traits\HasMedia\HasMedia;
use App\Models\Traits\HasMedia\HasMediaTrait;
use Cache;
use Fomvasss\UrlAliases\Traits\LocaleScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Request;

class MenuItem extends Model implements HasMedia
{
    use HasMediaTrait;
    use LocaleScopes;
    use NodeTrait;

    /** @var int URL-путь */
    const PATH_TYPE_PATH = 1;

    /** @var int URL-алиас */
    const PATH_TYPE_URL_ALIAS = 2;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'data' => 'array',
    ];

    protected $mediaFieldsSingle = [
        'image', 'img_desktop', 'img_tablet', 'img_mobile',
    ];

    protected $mediaFieldsValidation = [
        'image' => 'nullable|image|file|max:1024',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Model $model): void {
            Cache::forget('front_menus' . $model->locale);
        });
        static::deleted(function (Model $model): void {
            Cache::forget('front_menus' . $model->locale);
        });

        static::addGlobalScope('weight', function (Builder $builder): void {
            $builder->orderBy('locale', 'asc')
                ->orderBy('weight', 'asc')
                ->orderBy('id', 'asc');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function scopeByMenu($query, string $systemName)
    {
        return $query->whereHas('menu', function ($items) use ($systemName) {
            return $items->where('system_name', $systemName);
        })->byLocale();
    }

    /**
     * Relation with url-alias
     * https://github.com/fomvasss/laravel-url-aliases.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function urlAlias()
    {
        return $this->belongsTo(config('url-aliases.model', \Fomvasss\UrlAliases\Models\UrlAlias::class));
    }

    /**
     * @param $value
     */
    public function setPathAttribute($value): void
    {
        $this->attributes['path'] = rtrim(str_replace_first(Request::root(), '', $value), '/');
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getPathAttribute()
    {
        if ($this->attributes['path']) {
            return url($this->attributes['path']);
        }

        return '';
    }

    public function getTargetStr()
    {
        return $this->target ? 'target=' . $this->target : '';
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getUrl()
    {
        if ($this->path_type == self::PATH_TYPE_PATH && $this->attributes['path']) {
            return url($this->attributes['path']);
        } elseif ($this->path_type == self::PATH_TYPE_URL_ALIAS && $this->urlAlias) {
            return url($this->urlAlias->alias);
        }

        return '';
    }
}
