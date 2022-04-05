<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait SavePhones
{
    public static function addPhones(Request $request, Model $model): void
    {
        if ($model->phones) {
            $model->phones->each->delete();
        }

        if (isset($request->phones)) {
            foreach ($request->phones as $phone) {
                if (!empty($phone['phone'])) {
                    $model->phones()->create([
                        'phone' => $phone['phone'],
                    ]);
                }
            }
        }
    }
}
