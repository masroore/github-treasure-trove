<?php

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Contact\Entities\ContactModel;

class ContactFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'contact_type' => 'required',
            'name' => 'required',
            'email' => 'nullable',
            'business_name' => 'nullable',
            'contact_id' => 'nullable',
            'tax_number' => 'nullable',
            'opening_balance' => 'sometimes|nullable|numeric',
            'pay_term' => 'nullable',
            'pay_term_condition' => 'sometimes|nullable|string',
            'customer_group' => 'nullable',
            'credit_limit' => 'sometimes|nullable|numeric',
            'alternate_contact_no' => 'sometimes|nullable|string',
            'country_id' => 'sometimes|nullable|integer',
            'state' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'address' => 'sometimes|nullable|string',
            'note' => 'sometimes|nullable|string',
            'mobile' => 'sometimes|nullable|string',
        ];

        $user_id = null;
        if ($this->add_contact) {
            $contact = ContactModel::find($this->add_contact);
            if ($contact) {
                $user_id = $contact->user_id;
            }
        }

        if (app('general_setting')->first()->contact_login) {
            $rules['email'] = 'required|email|max:191|unique:users,email,' . $user_id;
            if (!$user_id) {
                $rules['password'] = ['required', 'min:6'];
            }
        }

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
