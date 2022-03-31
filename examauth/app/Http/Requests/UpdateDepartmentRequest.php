<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('department_edit');
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
