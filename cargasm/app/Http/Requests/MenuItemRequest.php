<?php

namespace App\Http\Requests;

use App\Models\Page;
use App\Models\Post;
use App\Rules\TranslationUuid;
use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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

        if ($this->model) {
            switch ($this->model) {
                case 'page':
                    $modelType = Page::class;

                    break;
                case 'post':
                    $modelType = Post::class;

                    break;
            }
            $this->merge([
                'model_type' => $modelType,
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
        $id = optional($this->menu_item)->id;

        return [
            'name' => 'required|string',
            'type' => 'required|in:path,model,delimiter',
            'path' => 'nullable|required_if:type,path|string',
            'model_type' => 'nullable|required_if:type,model|in:page,post',
            'model_id' => 'nullable|required_if:type,model|integer',
            'target' => 'nullable|in:_blank,_self,_parent,_top',
            'active' => 'required|boolean',
            'weight' => 'nullable|integer',
            'class' => 'nullable|string',
            'rel' => 'nullable|string',
            'img' => 'nullable|string',

            'lang' => 'nullable',
            //'translation_uuid' => [new TranslationUuid('menu_items', $this->lang, $id)],
        ];
    }
}
