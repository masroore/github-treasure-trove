<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            $id = $this->route('menu');
        }

        return [
            'name' => 'required|string|max:255',
            'system_name' => ['nullable', 'regex:/(^([a-z_]+)(\d+)?$)/u', 'unique:menus,system_name,' . $id],
            'publish' => 'sometimes|in:0,1',
        ];
    }
}
