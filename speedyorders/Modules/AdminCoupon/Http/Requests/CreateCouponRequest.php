<?php

namespace Modules\AdminCoupon\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:coupons,code',
            'type' => 'required|in:percentage,flat',
            'amount' => 'required|regex:/^\\d+(\\.\\d{1,2})?$/',
            'max_limit' => 'required|numeric',
            'limit_per_user' => 'required|numeric',
            'min_order_amount' => 'nullable|numeric',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'status' => 'required|in:0,1',
            'product_id' => 'sometimes|array',
            'product_id.*' => 'sometimes|numeric|max:255',
            'excluded_product_id' => 'sometimes|array',
            'excluded_product_id.*' => 'sometimes|numeric|max:255',
            'category_id' => 'sometimes|array',
            'category_id.*' => 'sometimes|numeric|max:255',
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
