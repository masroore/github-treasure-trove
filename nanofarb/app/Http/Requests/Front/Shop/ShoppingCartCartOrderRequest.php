<?php

namespace App\Http\Requests\Front\Shop;

use App\Http\Requests\BaseFormRequest;
use App\Models\Shop\Order;
use App\Rules\SalePromoCode;
use Auth;

class ShoppingCartCartOrderRequest extends BaseFormRequest
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
        $paymentMethodKeys = array_keys(Order::getPaymentMethods());

        $rules = [
            'data.delivery.method' => 'required|in:novaposhta,pickup,courier',
            'data.payment.method' => 'required|in:' . implode(',', $paymentMethodKeys),
            'data.delivery.phone' => 'required|string|between:12,12',
            'data.delivery.email' => 'nullable|email',
            'data.delivery.name' => 'required|string|max:191',
        ];

        if ($this->input('cart.promocode')) {
            $rules['cart.promocode'] = ['required', 'string', new SalePromoCode()];
        }

        if ($this->input('data.delivery.method') == 'novaposhta') {
            $rules = array_merge($rules, [
                //'data.delivery.city' => 'required|string',
                'data.delivery.tariff' => 'required|in:pvz,courier',
                'data.delivery.pvz' => 'required|string',
                'data.delivery.city' => 'required|string',
                //'data.delivery.address' => 'required|string',
            ]);
        } elseif ($this->input('data.delivery.method') == 'pickup') {
            //...
        } elseif ($this->input('data.delivery.method') == 'courier') {
            $cntIds = Auth::check() ? Auth::user()->contacts->pluck('id')->toArray() : [];

            $rules = array_merge($rules, [
                'data.delivery.city' => 'required_if:contact_id,0|nullable|string',
                'data.delivery.region' => 'required_if:contact_id,0|nullable|string',
                'data.delivery.zip_code' => 'required_if:contact_id,0|nullable|string',
                'data.delivery.address' => 'required_if:contact_id,0|nullable|string',
                'contact_id' => 'required|in:0,' . implode(',', $cntIds),
            ]);
        }

        return $rules;
    }

    /**
     * @return array|void
     */
    public function filters()
    {
        return [
            'data.delivery.phone' => 'digit',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'data.delivery.city.required_if' => 'Поле обязательно для заполнения.',
            'data.delivery.region.required_if' => 'Поле обязательно для заполнения.',
            'data.delivery.zip_code.required_if' => 'Поле обязательно для заполнения.',
            'data.delivery.address.required_if' => 'Поле обязательно для заполнения.',
        ];
    }
}
