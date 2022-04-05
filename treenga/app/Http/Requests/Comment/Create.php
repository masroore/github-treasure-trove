<?php

namespace App\Http\Requests\Comment;

use App\Http\Requests\ApiRequest;

class Create extends ApiRequest
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
            'body' => 'required',
            'parent_id' => 'nullable|integer',
            'subscribers' => 'nullable|array|min:1',
        ];
    }
}
