<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarModelRequest extends FormRequest
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
            'name' => 'required|string',
            'parent_id' => 'required|exists:car_models,id',
            'production_start' => 'required|integer|min:1900|max:2022|lte:production_end',
            'production_end' => 'required|integer|min:1900|max:2022|gte:production_start',
            'status' => 'sometimes|boolean',
        ];
    }
}
