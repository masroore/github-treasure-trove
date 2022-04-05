<?php

namespace App\Http\Requests\Control;

use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
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
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'robots' => 'nullable|in:index,noindex',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'robots' => $this->robots ? 'index' : 'noindex',
        ]);
    }
}
