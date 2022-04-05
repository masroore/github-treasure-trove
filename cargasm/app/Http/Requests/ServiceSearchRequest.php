<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceSearchRequest extends FormRequest
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

    protected function prepareForValidation(): void
    {
        $this->merge([
            'radius' => empty($this->radius) ? 10 : $this->radius,
            'lang' => config('app.locale'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //            'lang' => ['required', Rule::in(get_languages_keys())],
            'lang' => 'nullable',
            'latpoint' => 'numeric',
            'longpoint' => 'numeric',
            'radius' => 'nullable|integer',
        ];
    }
}
