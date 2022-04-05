<?php

namespace App\Http\Requests\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;

class SaleOptionsRequest extends FormRequest
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
            'discount_type' => 'sometimes|required|in:1,2',
            'discount' => 'required_with:discount_type',

            'terms' => 'sometimes|array',
            'terms.*' => 'nullable|exists:terms,id',
            'products' => 'sometimes|array',
            'products.*' => 'nullable|exists:products,id',
        ];
    }
}
