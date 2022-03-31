<?php

namespace Modules\AdminSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialMediaSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'facebook_url'=>'required|string|max:255',
            'instagram_url'=>'required|string|max:255',
            'pinterest_url'=>'required|string|max:255',
            'youtube_url'=>'required|string|max:255',
            'twitter_url'=>'required|string|max:255',
            'linkedin_url'=>'required|string|max:255',
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
