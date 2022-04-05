<?php

namespace App\Models;

use App\Models\Traits\HasMediaTrait;
use App\Models\Traits\HasSeoTrait;
use Fomvasss\Filterable\Filterable;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Variable;

class CarModel extends Model implements HasMedia
{
    use Filterable;
    use HasMediaTrait;
    use HasSeoTrait;
    use NodeTrait;
    use Sortable;

    protected $guarded = ['id'];

    public $timestamps = false;

    public $sortable = [
        'id',
        'title',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected $searchable = [
        'title',
    ];

    //public $mediaSingleCollections = ['photo'];
    public $mediaMultipleCollections = ['photos'];

    public function getLftName()
    {
        return 'left_key';
    }

    public function getRgtName()
    {
        return 'right_key';
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'mark_id', 'id');
    }

    public function models()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getSeo(): array
    {
        if ($tag = $this->metaTag) {
            return [
                'title' => $tag->title,
                'description' => $tag->description,
                'keywords' => $tag->keywords,
                'robots' => $tag->robots,
            ];
        }

        $var = Variable::getArray('seo_masks');

        return [
            'title' => $var['car_model']['fields']['title'] ?? '',
            'description' => '',
            'keywords' => '',
            'robots' => 'index',
        ];
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->format('jpg')
            ->quality(90)
            ->fit('crop', 100, 100)
            ->performOnCollections('photos')
            ->nonQueued();
    }
}
