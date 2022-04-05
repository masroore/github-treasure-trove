<?php

namespace App\Http\Requests\Control;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends FormRequest
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
            'text' => 'required|string',
            'parent_id' => 'nullable|integer',
            'user_id' => 'required|exists:users,id',
            'post_id' => 'sometimes|exists:posts,id',
        ];
    }
}
