<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('build_edit');
    }

    public function rules()
    {
        return [
            'categories_id' => [
                'required',
                'integer',
            ],
            'address' => [
                'string',
                'required',
            ],
            'kecamatans_id' => [
                'required',
                'integer',
            ],
            'kelurahans_id' => [
                'required',
                'integer',
            ],
            'lat' => [
                'string',
                'nullable',
            ],
            'lng' => [
                'string',
                'nullable',
            ],
        ];
    }
}
