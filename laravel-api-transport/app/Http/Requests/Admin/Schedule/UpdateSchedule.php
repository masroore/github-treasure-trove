<?php

namespace App\Http\Requests\Admin\Schedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateSchedule extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.schedule.edit', $this->schedule);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'date' => ['sometimes', 'date'],
            'time' => ['sometimes', 'date_format:H:i:s'],
            'cost' => ['sometimes', 'numeric'],
            'confirmed' => ['nullable', 'boolean'],
            'transport_id' => ['sometimes', 'string'],
            'route_id' => ['sometimes', 'string'],
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
