<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreAboutUsRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('about_us_create');
    }

    public function rules()
    {
        return [
            'description' => [
                'required',
            ],
        ];
    }
}
