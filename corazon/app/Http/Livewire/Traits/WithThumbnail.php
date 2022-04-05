<?php

namespace App\Http\Livewire\Traits;

use Illuminate\Support\Str;

trait WithThumbnail
{
    public function handleThumbnailUpload($model, array|string $thumb): void
    {
        $tableName = $model->getTable();

        if (gettype($thumb) == 'string') {
            $name = 'corazon-' . Str::slug($model->title, '-') . '-' . date('s');

            $model->addMediaFromUrl($thumb)
                ->withResponsiveImages()
                ->usingFileName($name)
                ->toMediaCollection($tableName);
            $model->thumbnail = $model->getMedia($tableName)->last()->getUrl();
            $model->save();
        } else {
            if ($thumb === [0]) {
                $model->thumbnail = '';
                $model->getMedia($tableName)->last()->delete();
                $model->save();

                return;
            }

            if (null === $model->thumbnail || ($model->thumbnail != $thumb['path'])) {
                $name = 'corazon-' . Str::slug($model->title, '-') . '-' . date('s') . '.' . $thumb['ext'];
                $model->addMedia($thumb['path'])
                    ->withResponsiveImages()
                    ->usingFileName($name)
                    ->toMediaCollection($tableName);
                $model->thumbnail = $model->getMedia($tableName)->last()->getUrl();
                $model->save();
            }
        }
    }
}
