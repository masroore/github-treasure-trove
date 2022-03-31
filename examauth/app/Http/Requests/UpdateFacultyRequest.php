<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('faculty_edit');
    }

    public function rules()
    {
        return [
            'falculty_name' => [
                'string',
                'required',
                'unique:faculties,falculty_name,' . request()->route('faculty')->id,
            ],
        ];
    }
}
