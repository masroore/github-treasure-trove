<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('department_create');
    }

    public function rules()
    {
        return [
            'department_name' => [
                'string',
                'required',
            ],
            'hod_id' => [
                'required',
                'integer',
            ],
            'faculty_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
