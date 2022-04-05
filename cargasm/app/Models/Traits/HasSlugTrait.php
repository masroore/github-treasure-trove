<?php

namespace App\Models\Traits;

trait HasSlugTrait
{
    //public static $slugSourceFields = ['name'];

    protected static function bootHasSlugTrait(): void
    {
        static::created(function ($model): void {
            if (empty($model->slug)) {
                if (property_exists(static::class, 'slugSourceFields') && !empty(static::$slugSourceFields)) {
                    $str = implode('-', $model->only(static::$slugSourceFields));
                    $model->slug = static::slugGenerate($str, $model);
                    $model->save();
                }
            }
        });
    }

    public static function slugGenerate(string $rawStr, $model = null)
    {
        $model = $model ?: new static();

        return app(\App\Helpers\UrlSlugGenerator::class)->slugGet($model, $rawStr);
    }
}
