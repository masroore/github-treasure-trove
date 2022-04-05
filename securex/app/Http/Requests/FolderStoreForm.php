<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;

class FolderStoreForm extends FormRequest
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
            'name' => 'required|min:3|max:14',
            'icon' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => Lang::get('alerts.folder.validation.folder_name_required'),
            'name.min' => Lang::get('alerts.folder.validation.folder_name_min'),
            'name.max' => Lang::get('alerts.folder.validation.folder_name_max'),
            'icon.required' => Lang::get('alerts.folder.validation.folder_icon_required'),
        ];
    }
}
