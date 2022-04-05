<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\ApiRequest;

class Attributes extends ApiRequest
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
            'categories' => 'nullable|array',
            'users' => 'nullable|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'categories.required' => 'Select at least one category',
        ];
    }
}
