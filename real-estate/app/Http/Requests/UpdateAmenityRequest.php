<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAmenityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('amenity_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:amenities,name,' . request()->route('amenity')->id,
            ],
        ];
    }
}
