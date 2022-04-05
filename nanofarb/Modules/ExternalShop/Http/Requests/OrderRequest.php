<?php

namespace Modules\ExternalShop\Http\Requests;

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
            'status' => 'required', // TODO byVocabulary
            'client.fullname' => 'required|string',
            'client.email' => 'nullable|email',
            'client.phone' => 'required|string',
            'delivery_service' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'payment_info' => 'nullable|string',
            'client_comment' => 'nullable|string',
            'seller_comment' => 'nullable|string',
        ];
    }
}
