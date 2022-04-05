<?php

namespace App\Http\Resources;

use App\Models\Event;
use App\Models\Photo;
use App\Models\Post;
use Illuminate\Http\Resources\Json\JsonResource;

class MainResource extends JsonResource
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
            case $this->timelines instanceof Post:
                $res = (new PostResource($this->whenLoaded('timelines')))->setAttrs($type = $this->type, $shares_user = $this->user, $shares_text = $this->description);

                break;
            case $this->timelines instanceof Event:
                $res = (new EventResource($this->whenLoaded('timelines')))->setAttrs($type = $this->type, $shares_user = $this->user, $shares_text = $this->description);

                break;
            case $this->timelines instanceof Photo:
                $res = (new PhotoResource($this->whenLoaded('timelines')))->setAttrs($type = $this->type, $shares_user = $this->user, $shares_text = $this->description);

                break;
        }

        return $res;
    }
}
