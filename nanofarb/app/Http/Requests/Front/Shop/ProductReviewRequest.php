<?php

namespace App\Http\Requests\Front\Shop;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
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
        return [
            'name' => 'sometimes|string|max:191',
            'body' => 'required|string|max:5000',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|between:1,5',
        ];
    }
}
