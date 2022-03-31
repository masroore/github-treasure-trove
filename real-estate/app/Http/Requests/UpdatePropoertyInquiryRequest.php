<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropoertyInquiryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('propoerty_inquiry_edit');
    }

    public function rules()
    {
        return [
            'property_id' => [
                'required',
                'integer',
            ],
            'full_name' => [
                'string',
                'required',
            ],
            'phone_number' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
