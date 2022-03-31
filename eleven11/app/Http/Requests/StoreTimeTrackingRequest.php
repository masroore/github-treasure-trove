<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTimeTrackingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('time_tracking_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'checkin_time' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'checkout_time' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
            'total_hours' => [
                'string',
                'nullable',
            ],
            'status' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ip_address' => [
                'string',
                'nullable',
            ],
            'random_code_id' => [
                'required',
                'integer',
            ],
            'shift_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
