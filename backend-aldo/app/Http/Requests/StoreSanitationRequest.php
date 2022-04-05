<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSanitationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sanitation_create');
    }

    public function rules()
    {
        return [
            'kecamatan_id' => [
                'required',
                'integer',
            ],
            'secure' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'basic' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'poor' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
        ];
    }
}
