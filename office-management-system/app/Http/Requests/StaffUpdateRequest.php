<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class StaffUpdateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'employee_id' => "required_if:role_type,!=,'system_user'",
            'name' => 'required',
            'username' => 'sometimes|nullable|numeric|unique:users,username,' . $request->user_id,
            'email' => 'required|unique:users,email,' . $request->user_id,
            'department_id' => 'required|numeric',
            'showroom_id' => 'required|numeric',
            'role_id' => 'required|nullable',
            'date_of_birth' => "required_if:role_type,!=,'system_user'",
            'current_address' => "required_if:role_type,!=,'system_user'",
            'permanent_address' => "required_if:role_type,!=,'system_user'",
            'bank_name' => "required_if:role_type,!=,'system_user'",
            'bank_branch_name' => "required_if:role_type,!=,'system_user'",
            'bank_account_name' => "required_if:role_type,!=,'system_user'",
            'bank_account_no' => "required_if:role_type,!=,'system_user'",
            'date_of_joining' => "required_if:role_type,!=,'system_user'",
            'basic_salary' => "required_if:role_type,!=,'system_user'",
            'employment_type' => "required_if:role_type,!=,'system_user'",
            'photo' => 'nullable|mimes:jpeg,jpg,png',
            'signature_photo' => 'nullable|mimes:jpeg,jpg,png',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ];
    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username' => trans('retailer.Phone'),
        ];
    }
}
