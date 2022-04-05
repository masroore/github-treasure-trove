<?php

namespace Modules\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowRoomFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('show_rooms', 'name')->ignore($this->id),
            ],
            'status' => [
                'required',
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return [
            'name' => 'The :attribute has been already used.',
        ];
    }

    public function messages()
    {
        // use trans instead on Lang
        return [
            'name.required' => 'The :attribute field must  have under 255 chars',
        ];
    }
}
