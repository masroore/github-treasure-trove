<?php

namespace Modules\Quotation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Please Choose at least one product',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
