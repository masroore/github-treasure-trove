<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TermRequest extends FormRequest
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
        $id = null;
        if (in_array($this->getMethod(), ['PATCH', 'PUT'])) {
            $segments = $this->segments();
            $id = end($segments);
        }

        return [
            'name' => 'required|string|between:1,100',
            'system_name' => ['nullable', 'regex:/(^([a-z_]+)(\d+)?$)/u', 'unique:terms,system_name,' . $id],
            'description' => 'nullable|string',
            'vocabulary' => 'required|exists:vocabularies,system_name',
            'publish' => 'sometimes|in:0,1',
            'parent_id' => 'nullable|exists:terms,id',
            'options' => 'nullable',
            'attributes' => 'sometimes|array|min:1',
            'locale' => 'sometimes|required|locale',
        ];
    }
}
