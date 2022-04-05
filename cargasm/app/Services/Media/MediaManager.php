<?php

namespace App\Services\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Models\Media;

class MediaManager
{
    /**
     * https://i.imgur.com/CQqIwjb.png.
     *
     * @return array
     */
    public function manage(Model $model, Request $request)
    {
        $res = [];

        // Multiple fields
        foreach ($model->mediaMultipleCollections ?? [] as $collectionName) {
            $res[$collectionName] = $this->processMultiple($model, $request, $collectionName);
        }

        // Single field
        foreach ($model->mediaSingleCollections ?? [] as $collectionName) {
            $res[$collectionName] = $this->processSingle($model, $request, $collectionName);
        }

        // Process deleted
        $this->processDeleted($model, $request);

        return $res;
    }

    public function processMultiple($model, $request, $collectionName)
    {
        $res = new Collection();
        foreach ($request->{$collectionName} ?? [] as $item) {
            $res->push($this->save($model, $item, $collectionName));
        }

        return $res;
    }

    public function processSingle($model, $request, $collectionName)
    {
        if (isset($request->{$collectionName}['file']) && $request->{$collectionName}['file'] instanceof UploadedFile) {
            $model->getMedia($collectionName)->each(function ($e): void {
                $e->delete();
            });
        }

        if ($request->{$collectionName}) {
            return $this->save($model, $request->{$collectionName}, $collectionName);
        }
    }

    public function processDeleted($model, $request, $collectionName = ''): void
    {
        $mediaDeletedField = 'media_deleted';
        if ($request->{$mediaDeletedField}) {
            $deletedIds = is_array($request->{$mediaDeletedField})
                ? $request->{$mediaDeletedField}
                : [$request->{$mediaDeletedField}];

            $issetIds = $model->media->pluck('id')->toArray();
            $deletedIds = array_intersect($deletedIds, $issetIds);

            foreach ($deletedIds as $id) {
                $this->delete($id, $collectionName);
            }
        }
    }

    /**
     * Сохранить данные записи Media и файл.
     *
     * @param array $attrs
     *  id int sometimes
     *  id file sometimes File for upload. If empty - update Media
     *  is_active boolean sometimes
     *  is_main boolean sometimes
     *  weight int sometimes
     *  title string sometimes
     *  alt int sometimes
     *  delete boolean sometimes If true - delete the file
     *
     * @return bool|\Spatie\MediaLibrary\Models\Media
     */
    public function save(Model $model, array $attrs, string $collectionName)
    {
        $media = null;

        $isActive = isset($attrs['is_active'])
            ? $this->comparisonBooleanValue($attrs['is_active'])
            : true;
        $isMain = isset($attrs['is_main'])
            ? $this->comparisonBooleanValue($attrs['is_main'])
            : false;
        $weight = $attrs['weight'] ?? null;

        $customProperties['title'] = $attrs['title'] ?? '';
        $customProperties['alt'] = $attrs['alt'] ?? '';

        // Удалить файл
        if (isset($attrs['delete']) && $this->comparisonBooleanValue($attrs['delete'])) {
            if (!empty($attrs['id']) && ($media = $model->media()->find($attrs['id']))) {
                $media->delete();
            }

            return true;

        // Загрузить новый файл
        } elseif (empty($attrs['id']) && isset($attrs['file']) && $attrs['file'] instanceof UploadedFile) {
            $uploadedFile = $attrs['file'];
            $originalName = $uploadedFile->getClientOriginalName();

            $filename = $this->generateFilename($originalName);

            /** @var \Spatie\MediaLibrary\Models\Media $media */
            $media = $model->addMedia($attrs['file'])
                ->usingFileName($filename)
                //->withCustomProperties($customProperties)
                ->toMediaCollection($collectionName);

        // Обновляем поля существующего файла
        } elseif (!empty($attrs['id'])) {
            /** @var \Spatie\MediaLibrary\Models\Media $media */
            $media = $model->media()->find($attrs['id']);
        }

        if ($media !== null) {
            if ($isMain === true) {
                $model->media()
                    ->where('collection_name', $collectionName)
                    ->update(['is_main' => false]);
            }

            $media->setCustomProperty('title', $customProperties['title'] ?? '');
            $media->setCustomProperty('alt', $customProperties['alt'] ?? '');

            $media->setAttribute('is_active', $isActive);
            $media->setAttribute('is_main', $isMain);
            if ($weight !== null) {
                $media->setAttribute('order_column', (int) $weight);
            }
            $media->save();

            return $media;
        }

        return false;
    }

    /**
     * Удалить Media.
     *
     * @param $mediaId
     *
     * @return null|bool
     */
    public function delete($mediaId, string $collectionName = '')
    {   /** @var Media $media */
        if ($media = Media::when($collectionName, function ($q) use ($collectionName): void {
            $q->where('collection_name', $collectionName);
        })->find($mediaId)) {
            return $media->delete();
        }

        return false;
    }

    protected function generateFilename(string $originalName): string
    {
        $fileName = pathinfo($originalName, PATHINFO_FILENAME);

        $fileName = \Illuminate\Support\Str::slug($fileName);

        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);

        return $fileName . '.' . $fileExtension;
    }

    /**
     * @param $value
     */
    protected function comparisonBooleanValue($value): bool
    {
        return $value === 'true' || $value === '1' || $value === true || $value === 1;
    }
}
