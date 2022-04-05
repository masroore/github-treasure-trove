<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'body' => 'nullable|string',
            'blade' => 'nullable|string|max:255',
            'publish' => 'sometimes|in:0,1',
            'url_alias' => 'sometimes|nullable|unique:url_aliases,alias',
            'locale' => 'nullable|locale',
        ];
    }
}
