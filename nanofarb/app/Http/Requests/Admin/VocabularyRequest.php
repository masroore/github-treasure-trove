<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VocabularyRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|between:1,100',
            'description' => 'nullable|string',
            'publish' => 'sometimes|in:0,1',
        ];

        $id = null;
        if ($this->isMethod('POST')) {
            $rules['system_name'] = ['nullable', 'regex:/(^([a-z_]+)(\d+)?$)/u', 'unique:vocabularies,system_name,'];
        } else {
            $id = $this->route()->parameter('vocabularies');
            dd($id);
            //$segments = $this->segments();
            //$id = end($segments);
            $rules['system_name'] = ['nullable', 'regex:/(^([a-z_]+)(\d+)?$)/u', 'unique:vocabularies,system_name,' . $id];
        }

        return $rules;
    }
}
