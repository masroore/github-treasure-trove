<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('course_edit');
    }

    public function rules()
    {
        return [
            'course_title' => [
                'string',
                'required',
                'unique:courses,course_title,' . request()->route('course')->id,
            ],
            'course_code' => [
                'string',
                'required',
                'unique:courses,course_code,' . request()->route('course')->id,
            ],
            'course_lecturer_id' => [
                'required',
                'integer',
            ],
            'department_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
