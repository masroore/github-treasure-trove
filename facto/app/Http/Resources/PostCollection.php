<?php

namespace App\Http\Resources;

use App\Models\Cat;
use App\Models\Post;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    public $collects = Post::class;

    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'category' => $this->get_cat($request->cat_id),
        ];

        // return parent::toArray($request);
    }

    public function get_cat($cat_id)
    {
        return Cat::find($cat_id);
    }

    public function with($request)
    {
        return [
            'status' => true,
        ];
    }
}
