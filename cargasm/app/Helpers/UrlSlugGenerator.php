<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UrlSlugGenerator
{
    protected $slugConfig = [
        'max_length' => 150,
        'separator' => '-',
    ];

    protected $classModelEntity;

    protected $currentModelEntity;

    protected $slugFieldName = 'slug';

    public function slugGet(Model $model, $strSlug = null): string
    {
        $this->classModelEntity = app()->make(get_class($model));

        $this->currentModelEntity = $model;

        $nonUniqueSlug = $this->makeNonUniqueSlug($strSlug);

        return $this->makeUniqueSlug($nonUniqueSlug);
    }

    protected function makeNonUniqueSlug(string $strSlug): string
    {
        return Str::slug($this->getClippedSlugWithPrefixSuffix($strSlug), $this->slugConfig['separator']);
    }

    public function getClippedSlugWithPrefixSuffix(string $slugSourceString): string
    {
        return Str::limit($slugSourceString, $this->slugConfig['max_length'], '');
    }

    protected function makeUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $i = 1;
        while ($this->otherRecordExistsWithSlug($slug) || $slug === '') {
            $slug = $originalSlug . '-' . $i++;
        }

        return $slug;
    }

    protected function otherRecordExistsWithSlug(string $slug): bool
    {
        return (bool) $this->classModelEntity::where('id', '<>', optional($this->currentModelEntity)->id)
            ->where($this->slugFieldName, '=', $slug)
            ->withoutGlobalScopes()
            ->first();
    }
}
