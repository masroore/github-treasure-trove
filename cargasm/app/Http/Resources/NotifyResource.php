<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

class NotifyResource extends JsonResource
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
            'type' => $this->type,
            'text' => $this->text,
            'entity' => $this->notifiable_type::where('id', $this->notifiable_id)->get(),
            //            'user' => AuthorResource::make($this->whenLoaded('user')),
            'user' => $this->when($this->notifiable_type === Message::class, function () {
                return AuthorResource::make($this->notifiable->senderData);
            }, function () {
                return AuthorResource::make($this->whenLoaded('user'));
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
