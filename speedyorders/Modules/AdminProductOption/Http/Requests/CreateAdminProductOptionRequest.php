<?php

namespace Modules\AdminProductOption\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminProductOptionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:255',
            'type'=>'required|in:option,input,select,radio,date,date_time,checkbox',
            'sort_order'=>'nullable|numeric',
            'option_value.name.*'=>'required|string|max:255',
            'option_value.image.*'=>'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'option_value.sort_order.*'=>'nullable|numeric|max:255',
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
