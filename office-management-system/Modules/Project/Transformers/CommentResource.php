<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event' => $this->event,
            'created_at' => $this->created_at,
            'pin_top' => $this->pin_top,
            'field' => new FieldResource($this->whenLoaded('field')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'new' => new CommentRelationResource($this->whenLoaded('new')),
            'old' => new CommentRelationResource($this->whenLoaded('old')),
            'comment' => $this->comment,
            'old_value' => $this->old_value,

        ];
    }
}
