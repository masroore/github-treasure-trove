<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreFacultyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('faculty_create');
    }

    public function rules()
    {
        return [
            'falculty_name' => [
                'string',
                'required',
                'unique:faculties',
            ],
        ];
    }
}
