<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreCrmNoteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('crm_note_create');
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer',
            ],
            'note' => [
                'required',
            ],
        ];
    }
}
