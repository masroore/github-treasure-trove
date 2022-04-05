<?php

namespace App\Http\Requests\Admin\Passenger;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePassenger extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.passenger.create');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'surname' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'second_name' => ['nullable', 'string'],
            'passport_series' => ['required', 'string'],
            'passport_number' => ['required', 'string'],
            'phone' => ['required', Rule::unique('passengers', 'phone'), 'string'],
            'deleted' => ['nullable', 'boolean'],

        ];
    }

    /**
     * Modify input data.
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
