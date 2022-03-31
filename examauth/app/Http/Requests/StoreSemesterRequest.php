<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreSemesterRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('semester_create');
    }

    public function rules()
    {
        return [];
    }
}
