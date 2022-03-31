<?php

namespace Modules\AdminPage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePageComponentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page_id' => 'required|numeric',
            'content' => 'required|string',
            'status' => 'required|numeric|in:0,1',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
