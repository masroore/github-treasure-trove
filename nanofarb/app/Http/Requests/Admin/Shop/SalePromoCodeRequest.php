<?php

namespace App\Http\Requests\Admin\Shop;

use App\Http\Requests\BaseFormRequest;

class SalePromoCodeRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string|between:4,30|unique:sale_promo_codes,code',
            'used_limit' => 'required|integer|min:0',
            'sale_id' => 'required',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date',
        ];
    }

    public function filters()
    {
        return [
            'start_at' => 'trim|format_date:m/d/Y, Y-m-d',
            'end_at' => 'trim|format_date:m/d/Y, Y-m-d',
        ];
    }
}
