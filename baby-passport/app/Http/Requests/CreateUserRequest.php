<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'user.name' => 'required',
            'user.email' => 'required|email|unique:users,email',
            'user_address.address' => 'required',
            'user_address.state' => 'required',
            'user_address.zip_code' => 'required',
            'user_address.country' => 'required',
            'user_address.country' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.name.required' => 'El nombre es obligatorio',
            'user.email.required' => 'El correo es obligatorio',
            'user.email.email' => 'El correo es inválido',
            'user.email.unique' => 'Este correo electrónico ya ha sido registrado',
            'user_address.address.required' => 'La dirección es obligatoria',
            'user_address.state.required' => 'El estado/pronvincia es obligatorio',
            'user_address.zip_code.required' => 'El código postal es obligatorio',
            'user_address.country' => 'El país es obligatorio',
        ];
    }
}
