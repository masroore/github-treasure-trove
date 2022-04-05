<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    protected static $models;

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
            'year' => $this->year,
            'status' => $this->status,
            'main_photo' => $this->getAllConversions(),
            'photos' => Media::collection($this->getMedia('images')),
            'mark_id' => $this->mark_id,
            'model_id' => $this->model_id,
            'descr' => $this->descr,
            'vin' => $this->vin ? hide_vin($this->vin) : '',
            'full_vin' => $this->when(optional(auth()->user())->id == $this->user->id, $this->vin),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_homemade' => $this->is_homemade,
            'user_id' => $this->user_id,
            'model' => $this->findById($this->model_id),
        ];
    }

    protected function findById($id)
    {
        foreach (self::$models as $val) {
            if ($val['id'] === $id) {
                return $val;
            }
        }

        return null;
    }

    public static function setModels(array $models = []): void
    {
        self::$models = $models;
    }
}
