<?php

namespace App\Http\Requests\Admin\Passenger;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePassenger extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.passenger.edit', $this->passenger);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'surname' => ['sometimes', 'string'],
            'first_name' => ['sometimes', 'string'],
            'second_name' => ['nullable', 'string'],
            'passport_series' => ['sometimes', 'string'],
            'passport_number' => ['sometimes', 'string'],
            'phone' => ['sometimes', Rule::unique('passengers', 'phone')->ignore($this->passenger->getKey(), $this->passenger->getKeyName()), 'string'],
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
