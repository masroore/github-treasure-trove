<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConversationInfoResource extends JsonResource
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
            'addressee' => $this->second,
            'sender' => $this->sender,
            'unread' => $this->unread,
            'created_at' => $this->created_at,
            'senderData' => AuthorResource::make($this->whenLoaded('firstData')),
            'addresseeData' => AuthorResource::make($this->whenLoaded('secondData')),
        ];
    }
}
