<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends Model implements HasMedia
{
    use Auditable;
    use HasFactory;
    use InteractsWithMedia;
    use MultiTenantModelTrait;
    use SoftDeletes;

    public const PER_SELECT = [
        'month' => 'Month',
        'year' => 'Year',
    ];

    public const STATUS_SELECT = [
        '1' => 'Approve',
        '0' => 'Disapprove',
    ];

    public $table = 'properties';

    protected $appends = [
        'property_main_photo',
        'property_photos',
        'floor_plans',
    ];

    protected $dates = [
        'year_built',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'property_title',
        'property_description',
        'type_id',
        'rooms',
        'property_price',
        'per',
        'google_map_location',
        'year_built',
        'area',
        'property_video',
        'status',
        'available',
        'feature_property',
        'location',
        'created_by_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getPropertyMainPhotoAttribute()
    {
        $file = $this->getMedia('property_main_photo')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function type()
    {
        return $this->belongsTo(Category::class, 'type_id');
    }

    public function getYearBuiltAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setYearBuiltAttribute($value): void
    {
        $this->attributes['year_built'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPropertyPhotosAttribute()
    {
        $files = $this->getMedia('property_photos');
        $files->each(function ($item): void {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
        });

        return $files;
    }

    public function getFloorPlansAttribute()
    {
        $file = $this->getMedia('floor_plans')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    public function tags()
    {
        return $this->belongsToMany(PropertyTag::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
