<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskFieldResource extends JsonResource
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
            'pivot' => [
                'field_id' => $this->pivot->field_id,
                'task_id' => $this->pivot->task_id,
                'number' => $this->pivot->number,
                'date' => $this->pivot->date,
                'text' => $this->pivot->text,
                'user_id' => $this->pivot->user_id,
                'option_id' => $this->pivot->option_id,
                'assinge' => new UserResource($this->pivot->assinge),
                'option' => new FieldOptionResource($this->pivot->option),
            ],
        ];
    }
}
