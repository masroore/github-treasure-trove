<?php

namespace Modules\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required',
            'ref_no' => 'required',
            'date' => 'required',
            'lc_no' => 'required',
            'lc_date' => 'required',
            'delivery_date' => 'required',
            'payment_term' => 'required',
            'discount' => 'required',
            'cnf_id' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
