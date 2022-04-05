<?php

namespace App\Http\Requests\Control;

use App\Rules\TranslationUuid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
        $id = optional($this->page)->id;

        return [
            'name' => 'required|string|min:1|max:255',
            'slug' => ['nullable', 'string', 'alpha_dash', Rule::unique('pages')->where(function ($q) use ($id): void {
                $q->where('slug', $this->slug)
                    ->where('lang', $this->lang)
                    ->where('id', '<>', $id);
            })],
            'content' => 'nullable|string',
            'lang' => 'nullable',
            'translation_uuid' => [new TranslationUuid('pages', $this->lang, $id)],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->isMethod('post')) {
            $this->merge([
                'lang' => config('app.locale'),
            ]);
        }
        if ($this->slug === null) {
            $this->merge([
                'slug' => Str::slug($this->name),
            ]);
        } else {
            $this->merge([
                'slug' => Str::slug($this->slug),
            ]);
        }
    }
}
