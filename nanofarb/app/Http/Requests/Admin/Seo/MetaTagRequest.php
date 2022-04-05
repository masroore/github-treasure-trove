<?php

namespace App\Http\Requests\Admin\Seo;

use App\Http\Requests\BaseFormRequest;

class MetaTagRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'path' => 'required|string|max:255|unique:meta_tags,path,' . $this->route()->parameter('meta_tag'),
            'title' => 'nullable|string|max:60',
            'keywords' => 'nullable|string|max:300',
            'description' => 'nullable|string|max:300',
            'seo_text' => 'nullable|string',
            'robots' => 'nullable|string|max:128',
            'priority' => 'nullable|in:' . implode(',', config('meta-tags.values.priority', [])),
            'changefreq' => 'required|in:' . implode(',', config('meta-tags.values.changefreq', [])),
        ];
    }

    public function filters()
    {
        return [
            'path' => 'url_without_root',
        ];
    }
}
