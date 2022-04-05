<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        if (!empty($this->video)) {
            foreach ($this->video as $key => $value) {
                $validator->sometimes('video.' . $key, ['regex:#^(https?:\/\/)?(www.)?(vimeo|youtube)#'], function () use ($value) {
                    preg_match('#^(https?:\/\/)?(www.)?(vimeo|youtube)#', $value['video'], $matches);

                    if ($matches) {
                        return false;
                    }

                    return true;
                });
            }
        }

        if (!empty($this->social)) {
            foreach ($this->social as $name => $link) {
                $validator->sometimes('social.' . $name, ['regex:#^(https?:\/\/)?(www.)?' . $name . '#'], function () use ($link) {
                    return $link ? true : false;
                });
            }
        }

        return $validator;
    }

    public function prepareForValidation(): void
    {
        $cleanVideoArray = [];

        if (!empty($this->video)) {
            foreach ($this->video as $key => $value) {
                if ($value['video']) {
                    $cleanVideoArray[$key] = $value;
                }
            }
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
            'main_photo' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phones' => 'array',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'working' => 'required|array',
            'descr' => 'required|string',
            'service' => 'required|array',
            'video' => 'nullable|array',
            'social' => 'nullable|array',
        ];
    }
}
