<?php

namespace Modules\AdminPage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'f_image' => 'nullable|image',
            'f_title' => 'nullable|string:max:255',
            'f_description' => 'nullable|string',
            'f_button_text' => 'nullable|string:max:255',
            'f_link' => 'nullable|string:max:255',
            's_image' => 'nullable|image',
            's_title' => 'nullable|string:max:255',
            's_description' => 'nullable|string',
            's_button_text' => 'nullable|string:max:255',
            's_link' => 'nullable|string:max:255',
            't_image' => 'nullable|image',
            't_title' => 'nullable|string:max:255',
            't_description' => 'nullable|string',
            't_button_text' => 'nullable|string:max:255',
            't_link' => 'nullable|string:max:255',
            'status' => 'required|string|in:0,1',
            'sort_order' => 'nullable:numeric',
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
