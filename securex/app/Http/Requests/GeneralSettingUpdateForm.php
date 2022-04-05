<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class GeneralSettingUpdateForm extends FormRequest
{
    // Route to redirect user to on validation failure.
    protected $redirectAction = 'Admin\Settings\GeneralSettingController@index';

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
            'app_name' => 'required|min:3|max:35',
            'app_description' => 'min:3|max:191',
            'app_email' => 'required',
            'app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'app_logo_white' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'app_locale' => 'required',
            'copyright_footer' => 'required|string|max:200',
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
            'app_name.required' => Lang::get('alerts.admin.settings.validation.app_name_required'),
            'app_name.min' => Lang::get('alerts.admin.settings.validation.app_name_min'),
            'app_name.max' => Lang::get('alerts.admin.settings.validation.app_name_max'),
            'app_description.max' => Lang::get('alerts.admin.settings.validation.app_description_max'),
            'app_description.max' => Lang::get('alerts.admin.settings.validation.app_description_min'),
            'app_email.required' => Lang::get('alerts.admin.settings.validation.app_email_required'),
            'app_locale.required' => Lang::get('alerts.admin.settings.validation.app_locale_required'),
            'app_theme.required' => Lang::get('alerts.admin.settings.validation.app_theme_required'),
        ];
    }
}
