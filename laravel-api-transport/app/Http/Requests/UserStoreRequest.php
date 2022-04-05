<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'surname' => 'required|max:255',
            'first_name' => 'required|max:255',
            'second_name' => 'max:255',
            'passport_series' => 'required|numeric|digits:4',
            'passport_number' => ['required', 'numeric', 'digits:6',
                Rule::unique('users')->ignore($this->id)->where(function ($query): void {
                    $query->where('passport_series', $this->get('passport_series'));
                }),
            ],
            'inn' => 'required|numeric|digits:12',
            'scan' => 'max:255',
            'birthday' => ['required', 'regex:/^20\d\d[- .](0[1-9]|1[012])[- .](0[1-9]|[12][0-9]|3[01])$/u'],
        ];
    }
}
