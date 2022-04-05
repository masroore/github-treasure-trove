<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKecamatanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kecamatan_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:kecamatans,name,' . request()->route('kecamatan')->id,
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
