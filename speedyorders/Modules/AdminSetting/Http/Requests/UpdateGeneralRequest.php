<?php

namespace Modules\AdminSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'required|max:255|string',
            'company_address' => 'required|max:255|string',
            'company_email' => 'required|string|max:255',
            'company_phone' => 'required|digits:10',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
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
