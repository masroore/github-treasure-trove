<?php

namespace Modules\Project\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectFieldResource extends JsonResource
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
            'name' => $this->name,
            'id' => $this->id,
            'default' => $this->default,
            'type' => $this->type,
            'pivot' => [
                'visibility' => $this->pivot->visibility,
                'field_id' => $this->pivot->field_id,
                'project_id' => $this->pivot->project_id,
                'order' => $this->pivot->order,
            ],
        ];
    }
}
