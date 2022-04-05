<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseFormRequest;

class UserRequest extends BaseFormRequest
{
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

        $rules = [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required_without:phone|nullable|email|unique:users,email,' . $id,
            'phone' => 'required_without:email|nullable|string|max:12',
            'publish' => 'sometimes|required|in:0,1',
            'password' => 'nullable|string|min:6|confirmed',

            'roles' => 'required|array',
            'roles.*' => 'required|string|exists:roles,name',
        ];
        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        return $rules;
    }

    /**
     * @return array|void
     */
    public function filters()
    {
        return [
            'phone' => 'digit',
        ];
    }
}
