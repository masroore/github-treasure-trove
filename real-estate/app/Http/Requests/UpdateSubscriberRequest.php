<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscriber_edit');
    }

    public function rules()
    {
        return [
            'email' => [
                'required',
            ],
        ];
    }
}
