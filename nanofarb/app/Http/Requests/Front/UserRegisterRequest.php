<?php

namespace App\Http\Requests\Front;

use App\Http\Requests\BaseFormRequest;

class UserRegisterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],

            'phone' => 'required|string|max:25|unique:users',
            'birthday' => 'nullable|date',
            'accept' => 'required|accepted',
            'data' => 'nullable|array',
        ];
    }

    public function filters()
    {
        return [
            'phone' => 'digit',
            'birthday' => 'trim|format_date:d.m.Y, Y-m-d',
        ];
    }
}
