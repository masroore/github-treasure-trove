<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class reCaptchaSettingUpdateForm extends FormRequest
{
    // Route to redirect user to on validation failure.
    protected $redirectAction = 'Admin\Modules\reCaptchaController@index';

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
            'recaptcha_site_key' => 'required|string',
            'recaptcha_secret_key' => 'required|string',
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
            'recaptcha_site_key.required' => Lang::get('alerts.admin.modules.recaptcha.validation.site_key_required'),
            'recaptcha_secret_key.required' => Lang::get('alerts.admin.modules.recaptcha.validation.secret_key_required'),
        ];
    }
}
