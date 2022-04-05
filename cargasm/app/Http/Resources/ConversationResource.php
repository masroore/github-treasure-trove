<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'first' => $this->first,
            'second' => $this->second,
            'sender' => $this->sender,
            'unread' => $this->unread,
            'message' => $this->message,
            'created_at' => $this->created_at,
            'firstData' => AuthorResource::make($this->whenLoaded('firstData')),
            'secondData' => AuthorResource::make($this->whenLoaded('secondData')),
        ];
    }
}
