<?php

namespace Modules\AdminProductQuestion\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminProductQuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answer'=>'nullable|string',
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'nullable|exists:customer_users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email',
            'status' => 'required|in:1,0',
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
