<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumUpdateRequest extends FormRequest
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
            'main_photo' => 'required',
            'photos' => 'nullable|array',
            'photos.file' => 'nullable|mimes:jpeg,jpg,png',
            'title' => 'string|max:255',
            'descr' => 'string',
            'lang' => 'nullable',
        ];
    }
}
