<?php

namespace Modules\AdminPage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminPageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'parent_id' => 'nullable|exists:pages,id',
            'slug' => 'required',
            'title' => 'required|string',
            'content' => 'required|string',
            'main_image' => 'required',
            'main_video' => 'required',
            'seo' => 'required|string',
            'seo_description' => 'required|string',
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
