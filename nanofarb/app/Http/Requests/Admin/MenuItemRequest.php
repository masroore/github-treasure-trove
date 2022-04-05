<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
            'path' => 'nullable|string|max:255',
            'url_alias_id' => 'nullable|exists:url_aliases,id',
            'target' => 'nullable|string|max:50',
            'weight' => 'sometimes|numeric',
            'path_type' => 'sometimes|between:1,2',
            'data' => 'nullable|array',
            'data.*.permissions' => 'nullable|exists:permissions,name',
            //'publish' => 'nullable|in:0,1',
            //'parent_id' => 'nullable|exists:menu_items,id',
            'locale' => 'nullable|locale',
        ];
    }
}
