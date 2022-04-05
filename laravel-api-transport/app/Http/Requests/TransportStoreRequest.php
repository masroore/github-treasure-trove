<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportStoreRequest extends FormRequest
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
            'car_number' => 'required|regex:/^[A-ZА-Я]\d{3}[A-ZА-Я]{2}\d{3}/u',
            'total_seats' => 'required|numeric|min:0',
            'model_id' => 'required|numeric|min:0',
        ];
    }
}
