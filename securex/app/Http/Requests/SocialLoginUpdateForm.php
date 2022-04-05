<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class SocialLoginUpdateForm extends FormRequest
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
            'github_enabled' => 'required',
            'github_client_id' => 'required_if:github_enabled,true|nullable|string',
            'github_client_secret' => 'required_if:github_enabled,true|nullable|string',
            'facebook_enabled' => 'required',
            'facebook_client_id' => 'required_if:facebook_enabled,true|nullable|string',
            'facebook_client_secret' => 'required_if:facebook_enabled,true|nullable|string',
            'twitter_enabled' => 'required',
            'twitter_client_id' => 'required_if:twitter_enabled,true|nullable|string',
            'twitter_client_secret' => 'required_if:twitter_enabled,true|nullable|string',
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
            'github_enabled.required' => Lang::get('alerts.admin.modules.social.validation.github_enabled_required'),
            'github_client_id.required_if' => Lang::get('alerts.admin.modules.social.validation.github_client_id_required_if'),
            'github_client_secret.required_if' => Lang::get('alerts.admin.modules.social.validation.github_client_secret_required_if'),
            'facebook_enabled.required' => Lang::get('alerts.admin.modules.social.validation.facebook_enabled_required'),
            'facebook_client_id.required_if' => Lang::get('alerts.admin.modules.social.validation.facebook_client_id_required_if'),
            'facebook_client_secret.required_if' => Lang::get('alerts.admin.modules.social.validation.facebook_client_secret_required_if'),
            'twitter_enabled.required' => Lang::get('alerts.admin.modules.social.validation.twitter_enabled_required'),
            'twitter_client_id.required_if' => Lang::get('alerts.admin.modules.social.validation.twitter_client_id_required_if'),
            'twitter_client_secret.required_if' => Lang::get('alerts.admin.modules.social.validation.twitter_client_secret_required_if'),
        ];
    }
}
