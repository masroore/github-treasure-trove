<?php

namespace App\Http\Requests\Control;

use App\Models\User;
use App\Rules\RuleFacebook;
use App\Rules\RuleOdnoklassniki;
use App\Rules\RuleVk;
use App\Rules\RuleYoutube;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $userId = optional($this->user)->id ?? 0;
//        $domainUrl = $this->domain;

        $rules = [
            'avatar' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'name' => 'nullable|string|max:255',
            'nickname' => 'required|string|unique:users,nickname,' . $this->user->id,
            'about' => 'nullable|max:255',
            'phone' => 'nullable|string|unique:users,phone,' . $this->user->id,
            'phones' => 'nullable|array',
            'social' => 'nullable|array',
            'social.youtube' => ['nullable', new RuleYoutube()],
            'social.ok' => ['nullable', new RuleOdnoklassniki()],
            'social.facebook' => ['nullable', new RuleFacebook()],
            'social.vk' => ['nullable', new RuleVk()],
            'notice' => 'nullable|array',
            'privacy' => 'nullable|array',
            'msg_reject' => 'nullable|string',
            'status' => 'required|in:' . implode(',', array_keys(User::statusesList())),
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:user,partner,admin',
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }
}
