<?php

namespace Modules\AdminSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaypalSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'paypal_live_client_id'=>'nullable|string|max:255',
            'paypal_live_secret_key'=>'nullable|string|max:255',
            'papapal_live_currency'=>'nullable|string|max:255',
            'paypal_sandbox_client_id'=>'nullable|string|max:255',
            'paypal_sandbox_secret_key'=>'nullable|string|max:255',
            'paypal_sandbox_currency'=>'nullable|string|max:255',
            'paypal_api_mode'=>'nullable|string',
            'paypal_enable_status'=>'nullable|string',
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
