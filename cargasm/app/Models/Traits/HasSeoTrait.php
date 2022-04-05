<?php

namespace App\Models\Traits;

use Fomvasss\LaravelMetaTags\Traits\Metatagable;

trait HasSeoTrait
{
    use Metatagable;

    protected static function bootHasSeoTrait(): void
    {
        self::deleting(function ($model): void {
            $model->seo()->delete();
        });
//        self::created(function ($model) {
//            $model->seo()->create();
//        });
    }

//    public function seo()
//    {
//        return $this->metaTag();
//    }
}
