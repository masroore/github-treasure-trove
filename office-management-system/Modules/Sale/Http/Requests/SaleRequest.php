<?php

namespace Modules\Sale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $customer = explode('-', $this->customer_id);
        $arr = [];
        if (count($customer) > 1) {
            $arr['customer'] = $customer[1];
            $arr['type'] = $customer[0];
        }
        $this->merge($arr);
    }

    public function rules()
    {
        $rules = [
            'customer_id' => ['required'],
            'customer' => ['required', Rule::exists('contacts', 'id')->where(function ($query) {
                return $query->where('contact_type', ucfirst($this->type));
            })],
            'type' => ['required', Rule::in(['customer'])],
            'date' => 'required',
            'warehouse_id' => 'required',
        ];

        if ($this->getMethod() == 'POST') {
            $rules += ['product_id' => 'required_without_all:combo_product_id,product'];
            $rules += ['payment_method' => 'required'];
        }

        if ($this->getMethod() == 'PUT') {
            $rules += ['product_id' => 'required_without_all:items,combo_items,product'];
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
