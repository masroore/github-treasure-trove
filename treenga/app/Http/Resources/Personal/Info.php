<?php

namespace App\Http\Resources\Personal;

use App\Http\Resources\Category\PrivateTree as CategoryPrivateTreeResource;
use App\Http\Resources\CustomData;
use Illuminate\Http\Resources\Json\JsonResource;

class Info extends JsonResource
{
    use CustomData;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'privateTree' => CategoryPrivateTreeResource::collection($this->privateTree),
        ];
    }
}
