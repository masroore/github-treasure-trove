<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateIpalRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ipal_edit');
    }

    public function rules()
    {
        return [
            'kelurahans_id' => [
                'required',
                'integer',
            ],
            'categories_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
                'unique:ipals,name,' . request()->route('ipal')->id,
            ],
            'address' => [
                'string',
                'required',
            ],
            'lat' => [
                'string',
                'nullable',
            ],
            'lng' => [
                'string',
                'nullable',
            ],
            'capacity' => [
                'numeric',
            ],
            'services.*' => [
                'integer',
            ],
            'services' => [
                'array',
            ],
            'photos' => [
                'array',
            ],
            'slug' => [
                'string',
                'nullable',
            ],
        ];
    }
}
