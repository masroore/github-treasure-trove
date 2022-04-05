<?php

namespace App\Models\Taxonomy;

use App\Models\Shop\Sale;
use App\Models\Traits\HasMedia\HasMedia;
use App\Models\Traits\HasMedia\HasMediaTrait;
use App\Models\Traits\HasSafe;
use App\Models\Traits\Metatagable;
use App\Traits\UrlAliasGenerator;
use Fomvasss\LaravelEUS\Facades\EUS;
use Fomvasss\UrlAliases\Traits\UrlAliasable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\Models\Media;

class Term extends \Fomvasss\Taxonomy\Models\Term implements HasMedia
{
    use HasMediaTrait;
    use HasSafe;
    use Metatagable;
    use UrlAliasable;
    use UrlAliasGenerator;

    protected $mediaFieldsSingle = ['image', 'file'];

    protected $mediaFieldsMultiple = ['images', 'files'];

    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('weight', function (Builder $builder): void {
            $builder->orderBy('locale', 'asc')
                ->orderBy('weight', 'asc')
                ->orderBy('id', 'asc');
        });
    }

    /**
     * Relation for attributes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function attrs()
    {
        return $this->morphedByMany(\App\Models\Shop\Attribute::class, 'termable');
    }

    /**
     * Предки.
     *
     * @return mixed
     */
    public function attrsAncestorsCategories()
    {
        return $this->ancestors->push($this)/*->load('attrs')*/ ->map(function ($term) {
            return $term->attrs;
        })->flatten()->unique('id');
    }

    /**
     * Потомки.
     *
     * @return mixed
     */
    public function attrsDescendantsCategories()
    {
        return $this->descendants->push($this)->load('attrs')->map(function ($term) {
            return $term->attrs;
        })->flatten()->unique('id');
    }

    public function products()
    {
        return $this->morphedByMany(\App\Models\Shop\Product::class, 'termable')->orderBy('id', 'desc');
    }

    /**
     * @return null|mixed|string
     */
    public function getSlugAttribute()
    {
        return $this->system_name ?? '';
    }

    /**
     * @return string
     */
    public function generateUrlAlias()
    {
        return $this->getUniqueAliasedPathForNestedEntity($this);
    }

    /**
     * @return string
     */
    public function generateUrlSource()
    {
        if (in_array($this->vocabulary, ['product_categories'])) {
            return trim(route('category.show', $this, false), '/');
        }

        return '';
    }

    public function generateMetaTags(): array
    {
        if (in_array($this->vocabulary, ['product_categories'])) {
            return array_merge($this->defaultMetaTags, [
                'title' => str_limit($this->name, 60, ''),
                'h1' => $this->name,
            ]);
        }

        return [];
    }

    public function sales()
    {
        return $this->morphToMany(Sale::class, 'model', 'saleables');
    }

    public function salesIsPublish()
    {
        return $this->morphToMany(Sale::class, 'model', 'saleables')
            ->isPublish();
    }

    public function generateSystemName()
    {
        if (in_array($this->vocabulary, ['order_statuses', 'payment_statuses', 'product_categories'])) {
            $slugSeparator = $this->vocabulary == 'product_categories' ? '-' : '_';

            return EUS::setEntity($this)
                ->setRawStr($this->name)
                ->setFieldName('system_name')
                ->setSlugSeparator($slugSeparator)
                ->get();
        }

        return '';
    }

    public function scopeIsPublish($query)
    {
        return $query->where('publish', 1);
    }

    public function statusAdminStr()
    {
        $styleClass = $this->options['admin_style'] ?? 'label label-success';

        return "<sbodypan class='$styleClass'> $this->name </sbodypan>";
    }

    public function customMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('table')
            ->format('jpg')->quality(93)
            ->fit('crop', 360, 257);
    }
}
