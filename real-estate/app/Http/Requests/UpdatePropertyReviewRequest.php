<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyReviewRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('property_review_edit');
    }

    public function rules()
    {
        return [
            'property_id' => [
                'required',
                'integer',
            ],
            'full_name' => [
                'string',
                'required',
            ],
            'ratings' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'email' => [
                'required',
            ],
            'review' => [
                'required',
            ],
        ];
    }
}
