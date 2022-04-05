<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'format' => $this->format,
            'label' => $this->label,
            'position' => $this->position,
            'decimal' => $this->decimal,
            'editable' => $this->editable,
            'notify' => $this->notify,
            'default' => $this->default,
            'options' => FieldOptionResource::collection($this->whenLoaded('options')),
        ];
    }
}
