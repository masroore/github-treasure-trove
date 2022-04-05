<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'conv_id' => $this->conv_id,
            'sender' => $this->sender,
            'addressee' => $this->addressee,
            'readed' => $this->readed,
            'sender_delete' => $this->sender_delete,
            'addressee_delete' => $this->addressee_delete,
            'message' => $this->message,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'senderData' => AuthorResource::make($this->whenLoaded('senderData')),
            'addresseeData' => AuthorResource::make($this->whenLoaded('addresseeData')),
            'docs' => Media::collection($this->whenLoaded('media')),
        ];
    }
}
