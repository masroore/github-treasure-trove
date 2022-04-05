<?php

namespace App\Http\Requests;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStoreRequest extends FormRequest
{
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('post_type', ['required', 'string', Rule::in([Post::TYPE_BLOG, Post::TYPE_NEWS])], function () {
            return auth()->user()->role === User::ROLE_ADMIN;
        });

        $validator->sometimes('author_type', ['required', 'string', Rule::in(['user', 'service'])], function () {
            // return dd(auth()->user());
            return auth()->user()->role === User::ROLE_PARTNER || auth()->user()->role === User::ROLE_ADMIN;
        });

        $validator->sometimes('author_id', ['required', 'integer'], function () {
            return auth()->user()->role === User::ROLE_PARTNER || auth()->user()->role === User::ROLE_ADMIN;
        });

        // $validator->sometimes('main_photo', 'required', function () {
        //     return $this->post_type === Post::TYPE_NEWS;
        // });

        return $validator;
    }

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
            'author_type' => 'required',
            'author_id' => 'required',
            'main_photo.file' => 'required|mimes:jpeg,jpg,png',
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'comment_allowed' => 'required|boolean',
            //            'status' => ['nullable'],
            'status' => ['required', 'string', 'max:255', Rule::in(array_column(Post::statusList(), 'key'))],
            'lang' => 'nullable',
        ];
    }
}
