<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProject extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'job_title' => 'required',
            'service_level' => 'required',
            'job_type' => 'required',
            'job_duration' => 'required',
            'job_skills' => 'required',
            'job_cat' => 'required',
            'job_description' => 'required',
        ];
    }
}
