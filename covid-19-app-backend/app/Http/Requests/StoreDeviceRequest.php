<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('device_create');
    }

    public function rules()
    {
        return [];
    }
}
