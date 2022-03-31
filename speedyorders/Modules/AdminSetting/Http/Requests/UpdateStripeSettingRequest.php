<?php

namespace Modules\AdminSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStripeSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stripe_key'=>'required|string|max:255',
            'stripe_secret'=>'required|string|max:255',
            'live_stripe_key'=>'required|string|max:255',
            'live_stripe_secret'=>'required|string|max:255',
            'stripe_payment_mode'=>'nullable|string',
            'stripe_enable_status'=>'nullable|string',
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
