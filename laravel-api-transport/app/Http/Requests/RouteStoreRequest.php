<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RouteStoreRequest extends FormRequest
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
            'departure_city_id' => 'required|numeric|min:0',
            'arrival_city_id' => 'required|numeric|min:0',
            'distance' => 'required|numeric|min:0',
            'user_id' => 'required|numeric|min:0',
        ];
    }
}
