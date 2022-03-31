<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShiftRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('shift_edit');
    }

    public function rules()
    {
        return [
            'shift_name' => [
                'string',
                'required',
            ],
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'start_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'end_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'days' => [
                'required',
            ],
            'company_id' => [
                'required',
                'integer',
            ],
            'active' => [
                'required',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'required',
                'array',
            ],
            'locations.*' => [
                'integer',
            ],
            'locations' => [
                'required',
                'array',
            ],
        ];
    }
}
