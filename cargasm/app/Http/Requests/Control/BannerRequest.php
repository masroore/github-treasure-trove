<?php

namespace App\Http\Requests\Control;

use App\Models\Banner;
use App\Rules\TranslationUuid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
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
        $id = optional($this->banner)->id;

        return [
            'name' => 'required|string',
            'sub_region' => ['nullable', Rule::in(array_keys(Banner::subRegionsList()))],
            'region' => ['required', Rule::in(array_keys(Banner::regionList()))],
            'weight' => 'sometimes|integer',
            'url' => 'nullable|url',
            'photo.file' => 'nullable|image',
            'target' => 'nullable|in:_blank,_self,_parent,_top',
            'is_active' => 'nullable|boolean',
            //            'lang' => ['nullable', Rule::in(get_languages_keys())],
            'lang' => 'nullable',
            //'translation_uuid' => [new TranslationUuid('banners', $this->lang, $id)],
        ];
    }
}
