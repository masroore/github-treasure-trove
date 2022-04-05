<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MetaTagRequest extends FormRequest
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
            'path' => 'required_without_all:metatagable_type,metatagable_id|url',
            'metatagable_type' => 'required_without:path|string',
            'metatagable_id' => 'required_without:path|integer',

            'h1' => 'sometimes|required|string|max:191',
            'title' => 'required|string|max:65',
            'description' => 'nullable|string|max:300',
            'keywords' => 'nullable|string|max:300',
        ];
    }
}
