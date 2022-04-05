<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreBuildGalleryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('build_gallery_create');
    }

    public function rules()
    {
        return [];
    }
}
