<?php

namespace Modules\Account\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'account_type' => 'required',
            'account_id' => 'required',
            'narration' => 'nullable',
            'main_amount' => 'required|same:sub_amounts',
            'sub_account_id' => 'required',
            'sub_amount' => 'required',
            'sub_narration' => 'required',
            'sub_amounts' => 'required',

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
