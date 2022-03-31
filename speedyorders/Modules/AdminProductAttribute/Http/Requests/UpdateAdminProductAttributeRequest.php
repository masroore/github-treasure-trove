<?php

namespace Modules\AdminProductAttribute\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminProductAttributeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attribute_label'=> 'required|string|max:255',
            'input_type'=> 'required',
            'is_required'=> 'required',
            'attribute_code'=> 'required|string|max:255',
            'include_in_filter'=>'required',
            'attribute_value.name.*'=>'required|string|max:255',
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
