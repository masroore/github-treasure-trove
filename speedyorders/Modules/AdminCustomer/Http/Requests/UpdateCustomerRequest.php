<?php

namespace Modules\AdminCustomer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [

            'first_name' =>'required|string|max:255',
            'last_name' =>'required|string|max:255',
            'email' =>'required|email|string|max:255',
            'telephone' =>'required|digits:10',
            'newsletter' =>'required|in:0,1',
            'safe' =>'required|in:0,1',
            'status' =>'required|in:0,1',
            'address_id'=>'nullable|numeric',
            'ip_id'=>'nullable|numeric',
            'transaction_id'=>'nullable|numeric',
            'description' =>'nullable|string',
            'amount' =>'nullable|numeric',
            'ip' =>'nullable|string',
            'total_accounts' =>'nullable|numeric',
        ];

        if (isset($this->address_id)) {
            $rules += [
                'a_first_name' =>'required|string|max:255',
                'a_last_name' =>'required|string|max:255',
                'address_1' =>'required|string',
                'address_2' =>'required|string',
                //'c_telephone' =>'required|digits:10',
                'city' =>'required|string|max:255',
                //'country' =>'required|string|max:255',
                //'region_id' =>'numeric',
            ];
        } elseif (isset($this->a_first_name)) {
            $rules += [
                'a_first_name' =>'required|string|max:255',
                'a_last_name' =>'required|string|max:255',
                'address_1' =>'required|string',
                'address_2' =>'required|string',
                //'c_telephone' =>'required|digits:10',
                'city' =>'required|string|max:255',
                //'country' =>'required|string|max:255',
                //'region_id' =>'numeric',
            ];
        }

        // if(isset($this->transaction_id))
        // {
        //     $rules += [
        //         'description' =>'required|string',
        //         'amount' =>'required|numeric',
        //     ];
        // }

        // if(isset($this->ip_id))
        // {
        //     $rules += [
        //         'ip' =>'required|string',
        //         'total_accounts' =>'required|numeric',
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
