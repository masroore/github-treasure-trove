<?php

namespace App\Http\Requests\Control;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarRequest extends FormRequest
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
            'status' => ['required', 'string', 'max:255', Rule::in(array_column(Car::statusList(), 'key'))],
            'mark_id' => 'required|exists:car_models,id',
            'model_id' => 'required|exists:car_models,id',
            'user_id' => 'required|exists:users,id',
            'descr' => 'nullable|string',
            'name' => 'nullable|string',
            'vin' => 'nullable|string|size:17',
            'is_sitemap' => 'required|boolean',
        ];
    }
}
