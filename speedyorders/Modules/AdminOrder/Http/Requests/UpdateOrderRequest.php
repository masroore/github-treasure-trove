<?php

namespace Modules\AdminOrder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $rules = [
            'customer_user_id' => 'required|integer',
            'invoice_number' => 'required|string:max:255',
            'invoice_prefix' => 'required|string:max:255',
            'first_name' => 'required|string:max:255',
            'last_name' => 'required|string:max:255',
            'address_1' => 'required|string:max:255',
            'address_2' => 'nullable|string:max:255',
            'email' => 'required|string:max:255',
            'postcode' => 'required|string:max:255',
            'phone' => 'required|string:max:255',

            'product_id' => 'nullable|array',
            'product_id.*' => 'nullable|numeric',
            'product_quantity' => 'nullable|array',
            'product_quantity.*' => 'nullable|numeric',
            'deletedProductId' => 'nullable',

            'shipping_first_name' => 'required|string:max:255',
            'shipping_last_name' => 'required|string:max:255',
            'shipping_company' => 'nullable|string:max:255',
            'shipping_address_1' => 'required|string:max:255',
            'shipping_address_2' => 'nullable|string:max:255',
            'shipping_city' => 'required|string:max:255',
            'shipping_postcode' => 'required|string:max:255',
            'shipping_country_name' => 'required|string:max:255',
            'shipping_region' => 'required|string:max:255',
            'shipping_method' => 'required|string:max:255',
            'shipping_unique_code' => 'nullable|string:max:255',
            'shipping_tracking_code' => 'nullable|string:max:255',

            'comment' => 'nullable|string',
            'status' => 'required:in:0,1',
            'commisison' => 'nullable|numeric',
            'currency_code' => 'required|string:max:255',
            'currency_value' => 'required|numeric',
            'ip' => 'nullable|string:max:255',
            'option.*'=>'nullable',
        ];

        if (isset($this->payment_method)) {
            $rules += [
            'payment_first_name' => 'required|string:max:255',
            'payment_last_name' => 'required|string:max:255',
            'payment_company' => 'required|string:max:255',
            'payment_address_1' => 'required|string:max:255',
            'payment_address_2' => 'nullable|string:max:255',
            'payment_city' => 'required|string:max:255',
            'payment_postcode' => 'required|string:max:255',
            'payment_country_name' => 'required|string:max:255',
            'payment_region' => 'required|string:max:255',
            'payment_method' => 'required|string:max:255',
            'payment_unique_code' => 'required|string:max:255',
            ];
        }

        // if(isset($this->coupon_id))
        // {
        //     $rules +=[
        //     'coupon_id' => 'required|numeric',
        //     ];
        // }

        return $rules;
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
