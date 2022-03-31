<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactUsMessageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contact_us_message_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
