<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatStoreMessage extends FormRequest
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
            'second' => 'required|integer',
            'message' => 'sometimes|required|string',
            'files.*' => 'nullable|mimes:doc,docx,jpeg,jpg,png,gif,pdf,fdf|max:1000',
        ];
    }
}
