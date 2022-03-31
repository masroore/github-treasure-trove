<?php

namespace Modules\AdminSetting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ups_live_username'=>'nullable|string|max:255',
            'ups_live_password'=>'nullable|string|max:255',
            'ups_live_api_key'=>'nullable|string|max:255',
            'ups_sandbox_username'=>'nullable|string|max:255',
            'ups_sandbox_password'=>'nullable|string|max:255',
            'ups_sandbox_api_key'=>'nullable|string|max:255',
            'ups_api_mode'=>'nullable|string',
            'box_length'=>'nullable|numeric',
            'box_breadth'=>'nullable|numeric',
            'box_height'=>'nullable|numeric',
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
