<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('student_profile_edit');
    }

    public function rules()
    {
        return [
            'student_name' => [
                'string',
                'required',
            ],
            'matric_number' => [
                'string',
                'required',
                'unique:student_profiles,matric_number,' . request()->route('student_profile')->id,
            ],
            'faculty_id' => [
                'required',
                'integer',
            ],
            'department_id' => [
                'required',
                'integer',
            ],
            'level' => [
                'required',
            ],
        ];
    }
}
