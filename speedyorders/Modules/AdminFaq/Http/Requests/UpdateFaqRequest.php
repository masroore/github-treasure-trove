<?php

namespace Modules\AdminFaq\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'faq_category_id' => 'required|exists:faq_categories,id',
            'type' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
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
