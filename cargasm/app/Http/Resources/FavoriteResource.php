<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
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
        $res = [
            'created_at' => $this->created_at,
        ];

        switch (true) {
            case $this->favoriteable instanceof Post:
                $res = (new PostResource($this->whenLoaded('favoriteable')));

                break;
            case $this->favoriteable instanceof Event:
                $res = (new EventResource($this->whenLoaded('favoriteable')));

                break;
            case $this->favoriteable instanceof Photo:
                $res = (new PhotoResource($this->whenLoaded('favoriteable')));

                break;
        }

        return $res;
    }
}
