<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PassengerStoreRequest extends FormRequest
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
            'surname' => 'required|max:255',
            'first_name' => 'required|max:255',
            'second_name' => 'max:255',
            'passport_series' => 'required|numeric|digits:4',
            'passport_number' => ['required', 'numeric', 'digits:6',
                Rule::unique('passengers')->ignore($this->id)->where(function ($query): void {
                    $query->where('passport_series', $this->get('passport_series'));
                }),
            ],
            'phone' => 'required|numeric|digits:11',
        ];
    }
}
