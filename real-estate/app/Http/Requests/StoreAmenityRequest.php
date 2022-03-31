<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreAmenityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('amenity_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:amenities',
            ],
        ];
    }
}
