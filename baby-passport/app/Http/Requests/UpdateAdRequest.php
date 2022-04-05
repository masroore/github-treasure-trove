<?php

namespace App\Http\Requests;

use App\Models\Advertising;

use Illuminate\Foundation\Http\FormRequest;
use Request;

class UpdateAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Advertising::rules(Request::segment(2), $this->request->all());
    }
}
