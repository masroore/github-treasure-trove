<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDensityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('density_edit');
    }

    public function rules()
    {
        return [
            'kelurahans_id' => [
                'required',
                'integer',
            ],
            'area' => [
                'numeric',
                'required',
            ],
            'population' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'density' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'year' => [
                'required',
            ],
        ];
    }
}
