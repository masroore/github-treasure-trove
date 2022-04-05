<?php

namespace Modules\Sale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleQuotationRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'customer_id' => 'required',
            'date' => 'required',
            'warehouse_id' => 'required',
        ];

        if ($this->getMethod() == 'POST') {
            $rules += ['product_id' => 'required_without_all:items,combo_items,product'];
            $rules += ['payment_method' => 'required'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'product_id.required_without_all' => 'Select At least one product',
            'product_id.required_without' => 'Select At least one product',
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
