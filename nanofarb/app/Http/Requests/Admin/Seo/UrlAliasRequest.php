<?php

namespace App\Http\Requests\Admin\Seo;

use App\Http\Requests\BaseFormRequest;

class UrlAliasRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'required|string|max:255|unique:url_aliases,alias',
            'source' => 'required|string|max:255',
            'type' => 'required|in:301,302',
        ];
    }

    public function filters()
    {
        return [
            'alias' => 'url_without_root',
            'source' => 'url_without_root',
        ];
    }
}
