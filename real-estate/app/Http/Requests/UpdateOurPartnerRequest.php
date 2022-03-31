<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOurPartnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('our_partner_edit');
    }

    public function rules()
    {
        return [];
    }
}
