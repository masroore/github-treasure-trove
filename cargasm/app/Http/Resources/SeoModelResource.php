<?php

namespace App\Http\Resources;

use Fomvasss\LaravelStrTokens\Facades\StrToken;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class SeoModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $arr = Arr::only($this->getSeo(), [
            'title', 'description', 'keywords', 'robots',
        ]);

        StrToken::setEntities(['node' => $this->resource]);

        return self::prepareMetatags($arr);
    }

    public static function prepareMetatags($arr)
    {
        $res = [];

        foreach ($arr as $key => $val) {
            if (!empty($val)) {
                $res[$key] = StrToken::setText($val)
                    ->setVars([
                        'site_name' => config('app.name'),
                        'site_description' => config('app.description', ''),
                        'site_phone' => config('app.phone', ''),
                    ])->replace();
            }
        }

        return $res;
    }
}
