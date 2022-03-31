<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSemesterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('semester_edit');
    }

    public function rules()
    {
        return [];
    }
}
