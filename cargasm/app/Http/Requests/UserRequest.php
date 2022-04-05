<?php

namespace App\Http\Requests;

use App\Rules\RuleFacebook;
use App\Rules\RuleOdnoklassniki;
use App\Rules\RuleVk;
use App\Rules\RuleYoutube;
use App\Rules\UniqueUserDataForDomain;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

//    protected function getValidatorInstance()
//    {
//        $validator = parent::getValidatorInstance();
//
//
//        foreach ($this->social as $name => $link) {
//            $validator->sometimes('social.' . $name, ['regex:#^(https?:\/\/)?(www.)?' . $name . '#'], function () use ($link) {
//                return $link ? true : false;
//            });
//        }
//
//        return $validator;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = optional($this->user())->id;

        return [
            'main_photo.file' => 'nullable|mimes:jpeg,jpg,png|dimensions:min_width=240,min_height=240',
            'email' => ['required', 'email', 'max:255', new UniqueUserDataForDomain('email')],
            'name' => 'required|string|max:255',
            'nickname' => ['required', new UniqueUserDataForDomain('nickname'), 'regex:/^[A-Za-z0-9_]+$/'],
            'about' => 'nullable|max:255',
            'phone' => ['nullable', 'string', new UniqueUserDataForDomain('phone')],
            'phones' => 'nullable|array',
            'social' => 'nullable|array',
            'social.youtube' => ['nullable', new RuleYoutube()],
            'social.ok' => ['nullable', new RuleOdnoklassniki()],
            'social.facebook' => ['nullable', new RuleFacebook()],
            'social.vk' => ['nullable', new RuleVk()],
            'address' => 'nullable|array',
            'notice' => 'nullable|array',
            'privacy' => 'nullable|array',
        ];
    }
}
