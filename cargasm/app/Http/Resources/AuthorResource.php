<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'type' => ($this->getTable() === 'users') ? 'user' : 'service',
            'slug' => ($this->getTable() === 'services') ? $this->slug : '',
            'main_photo' => $this->getAllConversions(),
        ];
    }
}
