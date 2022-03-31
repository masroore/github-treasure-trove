<?php

namespace Modules\Setting\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSabreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sabre_api_status' => 'required|in:active,inactive',
            'sabre_url' => 'required',
            'sabre_ipcc' => 'required',
            'sabre_id' => 'required',
            'sabre_password' => 'required',
            'sabre_printer_terminal' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
