<?php

namespace Modules\AdminStateTax\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStateTaxManagerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'state_code'=>'required|nullable',
            'tax_percentage'=>'required',
            'is_default'=>'required|in:1,0',
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
