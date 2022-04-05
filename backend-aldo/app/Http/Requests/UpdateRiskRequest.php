<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRiskRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('risk_edit');
    }

    public function rules()
    {
        return [
            'year' => [
                'required',
            ],
            'kelurahan_id' => [
                'required',
                'integer',
            ],
            'level' => [
                'required',
            ],
        ];
    }
}
