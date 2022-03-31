<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('location_create');
    }

    public function rules()
    {
        return [
            'location_code' => [
                'string',
                'required',
                'unique:locations',
            ],
            'location_name' => [
                'string',
                'required',
            ],
            'street_address' => [
                'string',
                'required',
            ],
            'city' => [
                'required',
            ],
            'state' => [
                'required',
            ],
            'country' => [
                'string',
                'required',
            ],
            'zip_code' => [
                'string',
                'required',
            ],
            'active' => [
                'required',
            ],
            'latitude' => [
                'string',
                'nullable',
            ],
            'longitude' => [
                'string',
                'nullable',
            ],
            'company_id' => [
                'required',
                'integer',
            ],
            'square_foot' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'call_in_numbers' => [
                'string',
                'nullable',
            ],
        ];
    }
}
