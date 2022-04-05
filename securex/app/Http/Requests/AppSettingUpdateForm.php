<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class AppSettingUpdateForm extends FormRequest
{
    // Route to redirect user to on validation failure.
    protected $redirectAction = 'Admin\Settings\SystemSettingController@index';

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
            'default_membership' => 'required',
            'max_vaults' => 'required|numeric',
            'max_folders' => 'required|numeric',
            'max_sites' => 'required|numeric',
            'max_notes' => 'required|numeric',
            'app_email_alerts' => 'required',
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
            'default_membership.required' => Lang::get('alerts.admin.settings.validation.default_membership_required'),
            'max_vaults.required' => Lang::get('alerts.admin.settings.validation.max_vaults_required'),
            'max_vaults.numeric' => Lang::get('alerts.admin.settings.validation.max_vaults_numeric'),
            'max_folders.required' => Lang::get('alerts.admin.settings.validation.max_folders_required'),
            'max_folders.numeric' => Lang::get('alerts.admin.settings.validation.max_folders_numeric'),
            'max_sites.required' => Lang::get('alerts.admin.settings.validation.max_sites_required'),
            'max_sites.numeric' => Lang::get('alerts.admin.settings.validation.max_sites_numeric'),
            'max_notes.required' => Lang::get('alerts.admin.settings.validation.max_notes_required'),
            'max_notes.numeric' => Lang::get('alerts.admin.settings.validation.max_notes_numeric'),
            'app_email_alerts.required' => Lang::get('alerts.admin.settings.validation.app_email_alerts_required'),
        ];
    }
}
