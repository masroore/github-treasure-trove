<?php

namespace App\Http\Resources\Control;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class SeoModelEditResource extends JsonResource
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
        return Arr::only($this->getSeo($this->lang), [
            'title', 'description', 'keywords',
        ]) + ['robots' => $this->robots === 'noindex' ? false : true];
    }
}
