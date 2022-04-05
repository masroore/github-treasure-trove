<?php

namespace Modules\Inventory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockTransferRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'date' => 'required',
            'from' => 'required',
            'to' => 'required',
            //            'to' => 'required|different:from',
        ];

        if ($this->getMethod() == 'POST') {
            $rules += ['product_id' => 'required'];
        }

        return $rules;
    }

    public function authorize()
    {
        return true;
    }
}
