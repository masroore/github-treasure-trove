<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
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

    protected function prepareForValidation(): void
    {
        if ($this->isMethod('post')) {
            $this->merge([
                'lang' => config('app.locale'),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'main_photo.file' => 'required|mimes:jpeg,jpg,png',
            'photos' => 'nullable|array',
            'photos.*.file' => 'required|mimes:jpeg,jpg,png',
            'title' => 'required|string|max:255',
            'descr' => 'required|string',
            //            'lang' => ['nullable', Rule::in(get_languages_keys())]
            'lang' => 'nullable',
        ];
    }
}
