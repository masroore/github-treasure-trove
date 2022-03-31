<?php

namespace Modules\AdminRbac\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:admin_users,email,' . $this->id,
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|alpha_dash|unique:admin_users,username,' . $this->id,
            'status' => 'required',
            'groups' => 'required',
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
