<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('property_tag_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:property_tags',
            ],
        ];
    }
}
