<?php

namespace Modules\AdminApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestCheckoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'first_name' => 'required|string:max:255',
                'last_name' => 'required|string:max:255',
                'address1' => 'required|string:max:255',
                'address2' => 'nullable|string:max:255',
                'email' => 'required|email|string:max:255',
                'postal_code' => 'required|string:max:255',
                'phone' => 'required|string:max:255',

                'shipping_first_name' => 'required|string:max:255',
                'shipping_last_name' => 'required|string:max:255',
                'shipping_company' => 'nullable|string:max:255',
                'shipping_address1' => 'required|string:max:255',
                'shipping_address2' => 'nullable|string:max:255',
                'shipping_city' => 'required|string:max:255',
                'shipping_postalcode' => 'required|string:max:255',
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
