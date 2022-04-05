<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreKecamatanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kecamatan_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:kecamatans',
            ],
            'color' => [
                'string',
                'min:4',
                'max:7',
                'required',
            ],
        ];
    }
}
