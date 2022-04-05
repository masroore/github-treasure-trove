<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $cleanVideoArray = [];
        foreach ($this->video as $key => $value) {
            if (!empty($value['video'])) {
                $cleanVideoArray[]['video'] = $value['video'];
            }
        }

        if ($this->isMethod('post')) {
            $this->merge([
                'lang' => config('app.locale'),
            ]);
        }

        $this->merge([
            'video' => $cleanVideoArray,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //            'lang' => ['nullable', Rule::in(get_languages_keys())],
            'lang' => 'nullable',
            'main_photo.file' => 'required|mimes:jpeg,jpg,png',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phones' => 'array',
            'country' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'working' => 'required|array',
            'descr' => 'required|string',
            'service' => 'required|array',
            'video' => 'nullable|array',
            'video.*.video.*' => 'nullable|url',
            'social' => 'nullable|array',
            'social.*' => 'nullable|url',
        ];
    }
}
