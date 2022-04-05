<?php

namespace App\Http\Requests\Admin\Shop;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'status' => 'sometimes|exists:terms,system_name', // TODO byVocabulary
            'payment_status' => 'sometimes|exists:terms,system_name', // TODO byVocabulary
            'data' => 'sometimes|array',
            'data.delivery.*' => 'nullable|string|max:255',
            'data.payment.*' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ];
    }
}
