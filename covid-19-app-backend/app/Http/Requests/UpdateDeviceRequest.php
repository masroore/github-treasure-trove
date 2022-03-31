<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('device_edit');
    }

    public function rules()
    {
        return [];
    }
}
