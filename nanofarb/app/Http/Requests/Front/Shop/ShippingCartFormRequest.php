<?php

namespace App\Http\Requests\Front\Shop;

use App\Rules\SalePromoCode;
use Illuminate\Foundation\Http\FormRequest;

class ShippingCartFormRequest extends FormRequest
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
        $rules = [];

        if ($this->input('purpose') == 'promocode') {
            $rules = array_merge($rules, [
                'cart.promocode' => ['required', 'string', new SalePromoCode()],
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'promocode.exists' => 'Код введен не верно или истек срок его действия',
        ];
    }
}
