<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('property_tag_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:property_tags,name,' . request()->route('property_tag')->id,
            ],
        ];
    }
}
