<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKelurahanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kelurahan_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:kelurahans,name,' . request()->route('kelurahan')->id,
            ],
            'kecamatans_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
