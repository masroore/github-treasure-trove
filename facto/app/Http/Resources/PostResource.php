<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public static $wrap = 'post';

    public $preserveKeys = true;

    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'cat_id' => $this->cat_id,
            // ‘company’ => $this->whenLoaded(‘company’, $this->company),

            'photo' => $this->photo,
            'option' => $this->option,
            'thumb_path' => $this->thumb_path,
            'title' => $this->title,
            'content' => $this->content,
            'iframe_src' => $this->iframe_src,
            'outlink1' => $this->outlink1,
            'outlink2' => $this->outlink2,
            'thumb' => $this->thumb,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
