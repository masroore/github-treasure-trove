<?php

namespace Modules\AdminShipping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'package_type' => 'required',
            'package_size_unit' => 'required',
            'package_name' => 'required',
            'package_length' => 'required|numeric',
            'package_height' => 'required|numeric',
            'package_width' => 'required|numeric',
            'is_default' => 'required|in:0,1',
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
