<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildGalleryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('build_gallery_edit');
    }

    public function rules()
    {
        return [];
    }
}
