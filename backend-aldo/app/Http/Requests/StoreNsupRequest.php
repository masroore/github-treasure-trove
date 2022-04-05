<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreNsupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('nsup_create');
    }

    public function rules()
    {
        return [
            'categories_id' => [
                'required',
                'integer',
            ],
            'kecamatans_id' => [
                'required',
                'integer',
            ],
            'kelurahans_id' => [
                'required',
                'integer',
            ],
            'years' => [
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
        ];
    }
}
