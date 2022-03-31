<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('subscriber_create');
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
