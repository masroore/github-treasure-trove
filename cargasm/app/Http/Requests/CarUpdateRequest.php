<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarUpdateRequest extends FormRequest
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
            'name' => 'string',
            'main_photo' => 'required',
            'mark_id' => ['nullable', 'integer', Rule::requiredIf($this->get('is_homemade') == false)],
            'model_id' => ['nullable', 'integer', Rule::requiredIf($this->get('is_homemade') == false)],
            'descr' => 'string',
            'vin' => 'nullable|string',
            'is_homemade' => 'boolean|nullable',
        ];
    }
}
