<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\BaseFormRequest;
use Auth;

class AccountRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password_current' => 'nullable|required_with:password|string|min:6|password_current:' . Auth::user()->password,
            'password' => 'nullable|string|min:6|confirmed',

            'phone' => 'required|string|min:9,max:25',
            'birthday' => 'nullable|date',
            'subscriber' => 'nullable|in:0,1',

            'contact_id' => 'sometimes|required|exists:contacts,id',
            'contact.*' => 'required|string',
        ];
    }

    public function filters()
    {
        //$data = $this->get('birthday').'/'.$this->get('birthmonth').'/'.$this->get('birthyeay', date('Y'));
        return [
            'phone' => 'digit',
        ];
    }
}
