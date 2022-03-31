<?php

namespace Modules\AdminCategory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'=>'nullable|exists:categories,id',
            'name'=>'required|string|max:255',
            'slug'=>'nullable|string|max:255|unique:categories,slug',
            'description'=>'required|string',
            'return_policy'=>'required|string',
            'status'=>'required|in:1,0',
            'is_featured'=>'required|in:1,0',
            'show_on_homepage'=>'required|in:1,0',
            'sort_order' => 'nullable|numeric',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:4096',
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
