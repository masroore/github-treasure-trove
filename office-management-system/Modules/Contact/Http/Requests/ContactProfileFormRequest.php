<?php

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactProfileFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'nullable',
            'tax_number' => 'nullable',
            'country_id' => 'sometimes|nullable|integer',
            'state' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'note' => 'sometimes|nullable|string',
            'mobile' => 'sometimes|nullable|string',
            'password' => 'sometimes|nullable|confirmed',
            'password_confirmation' => 'required_with:password,',
        ];

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
