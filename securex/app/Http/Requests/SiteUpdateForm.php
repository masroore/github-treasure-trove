<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class SiteUpdateForm extends FormRequest
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
            'name' => 'required|min:3|max:35',
            'link' => 'max:155',
            'login_id' => 'required|min:3|max:155',
            'login_password' => 'required|min:3|max:155',
            'additional_info' => 'max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => Lang::get('alerts.site.validation.name_required'),
            'name.min' => Lang::get('alerts.site.validation.name_min'),
            'name.max' => Lang::get('alerts.site.validation.name_max'),
            'link.max' => Lang::get('alerts.site.validation.link_max'),
            'login_id.required' => Lang::get('alerts.site.validation.login_id_required'),
            'login_id.min' => Lang::get('alerts.site.validation.login_id_min'),
            'login_id.max' => Lang::get('alerts.site.validation.login_id_max'),
            'login_password.required' => Lang::get('alerts.site.validation.login_password_required'),
            'login_password.min' => Lang::get('alerts.site.validation.login_password_min'),
            'login_password.max' => Lang::get('alerts.site.validation.login_password_max'),
            'additional_info.max' => Lang::get('alerts.site.validation.additional_info_max'),
        ];
    }
}
