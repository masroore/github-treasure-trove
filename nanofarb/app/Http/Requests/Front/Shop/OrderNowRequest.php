<?php

namespace App\Http\Requests\Front\Shop;

use App\Http\Requests\BaseFormRequest;

class OrderNowRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required_without:phone|string|min:10',
            'phone' => 'required_without:email|string|between:12,12',
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1|max:100',
        ];
    }

    public function filters()
    {
        return [
            'phone' => 'digit',
        ];
    }
}
