<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreKelurahanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kelurahan_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:kelurahans',
            ],
            'kecamatans_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
