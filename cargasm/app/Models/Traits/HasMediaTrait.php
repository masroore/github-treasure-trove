<?php

namespace App\Models\Traits;

use App\Services\Media\MediaManager;
use Illuminate\Http\UploadedFile;

trait HasMediaTrait
{
    use \Spatie\MediaLibrary\HasMedia\HasMediaTrait;

    /** Define in your Model class: */
    // public $mediaMultipleCollections = [];
    // public $mediaSingleCollections = [];

    public function media()
    {
        return $this->morphMany(config('medialibrary.media_model'), 'model')
            ->orderBy('order_column', 'asc')
            ->orderBy('id', 'asc');
    }

    public function getFirstMediaUrl(string $collectionName = 'default', string $conversionName = ''): string
    {
        $media = $this->getFirstMedia($collectionName);

        if (!$media) {
            return $this->getFallbackMediaUrl($collectionName) ?: '';
        }

        return url($media->getUrl($conversionName));
    }

    public function getMainMedia(string $collectionName = '')
    {
        return $this->getMedia($collectionName)
            ->where('is_main', true)
            ->where('is_active', true)
            ->first();
        //  ?: $this->getMedia($collectionName)->first();
    }

    /**
     * @return array
     */
    public function mediaManage(\Illuminate\Http\Request $request)
    {
        $manager = app(MediaManager::class);

        return $manager->manage($this, $request);
    }

    /**
     * @return bool|\Spatie\MediaLibrary\Models\Media
     */
    public function mediaSave(array $attrs, string $collectionName, bool $deleteOther = false)
    {
        $manager = app(MediaManager::class);

        if ($deleteOther && isset($attrs['file']) && $attrs['file'] instanceof UploadedFile) {
            $this->getMedia($collectionName)->each(function ($e): void {
                $e->delete();
            });
        }

        return $manager->save($this, $attrs, $collectionName);
    }

    public function mediaDelete($mediaId, $collectionName = ''): void
    {
        if ($mediaId) {
            $manager = app(MediaManager::class);

            $ids = is_array($mediaId) ? $mediaId : [$mediaId];

            foreach ($ids as $id) {
                $manager->delete($id, $collectionName);
            }
        }
    }
}
