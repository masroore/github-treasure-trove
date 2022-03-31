<?php

namespace Modules\AdminCustomer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' =>'required|string|max:255',
            'last_name' =>'required|string|max:255',
            'email' =>'required|email|string|max:255',
            'telephone' =>'required|digits:10',
            'newsletter' =>'required|in:0,1',
            'safe' =>'required|in:0,1',
            'status' =>'required|in:0,1',

            'a_first_name' =>'nullable|string|max:255',
            'a_last_name' =>'nullable|string|max:255',
            'address_1' =>'nullable|string',
            'address_2' =>'nullable|string',
            //'c_telephone' =>'nullable|digits:10',
            'city' =>'nullable|string|max:255',
            //'country' =>'nullable|string|max:255',
            //'region_id' =>'nullable|numeric',

            //'description' =>'nullable|string',
            //'region_id' =>'nullable|numeric',

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
