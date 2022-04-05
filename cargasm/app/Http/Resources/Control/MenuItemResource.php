<?php

namespace App\Http\Resources\Control;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'path' => $this->path,
            'target' => $this->target ?? '',
            'active' => $this->active,
            'weight' => $this->weight,
            'class' => $this->class,
            'rel' => $this->rel,
            'img' => $this->img,

            'lang' => $this->lang,
            //'translation_uuid' => $this->translation_uuid,
            //'translations' => TranslationResource::collection($this->whenLoaded('translations')),
            //            'translations' => $this->when($this->relationLoaded('translations'), function () {
            //                return $this->getTranslationsList();
            //            }),
        ];
    }
}
