<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
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
            'date' => ['required', 'regex:/^20\d\d[- .](0[1-9]|1[012])[- .](0[1-9]|[12][0-9]|3[01])$/u'],
            'time' => 'required|date_format:H:i',
            'cost' => 'required|numeric|min:0',
            'confirmed' => 'nullable',
            'transport_id' => 'required|numeric|min:0',
            'route_id' => 'required|numeric|min:0',
        ];
    }
}
