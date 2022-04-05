<?php
/**
 * File name: Upload.php
 * Last modified: 2021.01.03 at 12:13:26
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2021.
 */

namespace App\Models;

use Eloquent as Model;
use Illuminate\Support\Collection;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Upload extends Model implements HasMedia
{
    use HasMediaTrait {
        getMedia as protected getMediaTrait;
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }

    public $fillable = [
        'uuid',
    ];

    private $performed = 'default';

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_FILL, 200, 200)
            ->sharpen(10);

        $this->addMediaConversion('icon')
            ->fit(Manipulations::FIT_FILL, 100, 100)
            ->sharpen(10);
    }

    // TODO
    public function getFirstMediaUrl($collectionName = 'default', $conversion = '')
    {
        $url = $this->getFirstMediaUrlTrait($collectionName);
        if ($url) {
            $array = explode('.', $url);
            $extension = strtolower(end($array));
            if (in_array($extension, ['jpg', 'png', 'gif', 'bmp', 'jpeg'])) {
                return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
            }

            return asset('images/icons/' . $extension . '.png');
        }

        return asset('images/image_default.png');
    }

    public function getPerformed(): string
    {
        return $this->performed;
    }

    public function setPerformed(string $performed): void
    {
        $this->performed = $performed;
    }

    /**
     * get media.
     *
     * @param array $filters
     *
     * @return Collection
     */
    public function getMedia(string $collectionName = 'default', $filters = [])
    {
        if (count($this->getMediaTrait($collectionName))) {
            return $this->getMediaTrait($collectionName, $filters);
        }

        return $this->getMediaTrait('default', $filters);
    }
}
