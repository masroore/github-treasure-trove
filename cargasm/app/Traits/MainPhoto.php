<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait MainPhoto
{
    public static function addMainPhoto(Request $request, Model $model): void
    {
        if ($request->main_photo) {
            $model->clearMediaCollection('main_photo');
            $model->addMedia($request->main_photo)->toMediaCollection('main_photo');
        }
    }
}
