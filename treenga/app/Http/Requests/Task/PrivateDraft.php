<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\ApiRequest;

class PrivateDraft extends ApiRequest
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
            'task_id' => 'nullable',
            'name' => 'nullable',
            'body' => 'nullable',
            'categories' => 'nullable|array|min:1',
            'due_date' => 'nullable|date',
        ];
    }
}
