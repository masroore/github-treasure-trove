<?php

namespace App\Http\Requests\Control;

use App\Models\Post;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        // 'user_id', 'author_type', 'author_id'
        return [
            'photo.file' => 'nullable|mimes:jpeg,jpg,png',
            'title' => 'required|string|max:255',
            'slug' => 'sometimes|string',
            'text' => 'required|string',
            'msg_reject' => 'nullable|string',
            'comment_allowed' => 'required|boolean',
            'status' => ['required', Rule::in(array_keys(Post::statusesList()))],
            'post_type' => ['required', Rule::in(array_keys(Post::typesList()))],
            //            'lang' => ['required', Rule::in(get_languages_keys())], //TODO
            'user_id' => 'required|exists:users,id',
            'author_type' => ['required', Rule::in(array_keys(Post::authorTypesList()))],
            'author_id' => 'required|integer',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->isMethod('post')) {
            $this->merge([
                'lang' => config('app.locale'),
            ]);
        }

        if (($this->isMethod('post') || $this->has('slug')) && ($str = $this->slug ?: $this->title)) {
            $this->merge([
                'slug' => Post::slugGenerate($str, $this->route('post')),
            ]);
        }

//        if ($this->comment_allowed !== null) {
//                $this->merge([
//                'comment_allowed' => $this->comment_allowed === 'true' || $this->comment_allowed === true || $this->comment_allowed === 1 || $this->comment_allowed === '1',
//            ]);
//        }

        if (empty($this->service_id)) {
            $this->merge([
                'author_id' => $this->user_id,
                'author_type' => User::class,
            ]);
        } else {
            $this->merge([
                'author_id' => $this->service_id,
                'author_type' => Service::class,
            ]);
        }
    }
}
