<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('property_edit');
    }

    public function rules()
    {
        return [
            'property_title' => [
                'string',
                'required',
                'unique:properties,property_title,' . request()->route('property')->id,
            ],
            'property_description' => [
                'required',
            ],
            'type_id' => [
                'required',
                'integer',
            ],
            'rooms' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'property_price' => [
                'required',
            ],
            'per' => [
                'required',
            ],
            'google_map_location' => [
                'required',
            ],
            'year_built' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'area' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'property_video' => [
                'string',
                'required',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
            'available' => [
                'required',
            ],
            'location' => [
                'string',
                'required',
            ],
            'amenities.*' => [
                'integer',
            ],
            'amenities' => [
                'array',
            ],
        ];
    }
}
