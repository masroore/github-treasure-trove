<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAlertRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_alert_edit');
    }

    public function rules()
    {
        return [];
    }
}
