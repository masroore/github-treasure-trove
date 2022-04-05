<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarStoreRequest extends FormRequest
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
            'main_photo.file' => 'required|mimes:jpeg,jpg,png',
            'name' => 'required|string',
            'mark_id' => ['nullable', 'integer', Rule::requiredIf($this->get('is_homemade') == false)],
            'model_id' => ['nullable', 'integer', Rule::requiredIf($this->get('is_homemade') == false)],
            'descr' => 'string',
            'year' => 'nullable|integer',
            'is_homemade' => 'boolean',
            'vin' => 'nullable|string',
        ];
    }
}
