<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuWithItemsResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'items' => $this->getItems(),
        ];
    }

    public function getItems()
    {
        return $this->items->where('active', true)->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'path' => $item->path,
                'type' => $item->type,
                'target' => $item->target,
                'weight' => $item->weight,
                'class' => $item->class,
                'rel' => $item->rel,
                'img' => $item->img,
                'lang' => $item->lang,
            ];
        });
    }
}
