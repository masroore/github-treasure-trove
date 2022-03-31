<?php

namespace Modules\AdminFaq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminFaqCategoryrequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'meta_tag' => 'required|string|max:255',
            'sort_order' => 'required|integer',
            'status' => 'required|in:1,0',
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
