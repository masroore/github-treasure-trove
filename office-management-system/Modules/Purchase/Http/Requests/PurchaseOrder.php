<?php

namespace Modules\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrder extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $setting = app('general_setting');
        $rules = [
            'supplier_id' => 'required',
            'showroom' => 'required',
        ];

        if ($this->getMethod() == 'POST') {
            $rules += ['product_id' => 'required'];
            $rules += ['payment_method' => 'required'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Select At least one product',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
