<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSecuredRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('secured_create');
    }

    public function rules()
    {
        return [
            'kecamatan_id' => [
                'required',
                'integer',
            ],
            'access_id' => [
                'required',
                'integer',
            ],
            'communal' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'individual' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'mck_user' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
            'qty_sr_pdpal' => [
                'required',
                'integer',
                'min:0',
                'max:2147483647',
            ],
        ];
    }
}
