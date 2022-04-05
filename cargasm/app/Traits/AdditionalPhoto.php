<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait AdditionalPhoto
{
    public static function addPhotos(Request $request, Model $model): void
    {
        if ($request->photos) {
            foreach ($request->photos as $photo) {
                $model->addMedia($photo)->toMediaCollection('photos');
            }
        }
    }
}
