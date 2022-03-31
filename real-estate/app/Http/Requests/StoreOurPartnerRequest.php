<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreOurPartnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('our_partner_create');
    }

    public function rules()
    {
        return [
            'logo' => [
                'required',
            ],
        ];
    }
}
