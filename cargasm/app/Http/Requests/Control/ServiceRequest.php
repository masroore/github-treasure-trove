<?php

namespace App\Http\Requests\Control;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

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
        if ($this->isMethod('post')) {
            $this->merge([
                'lang' => config('app.locale'),
            ]);
        }

        $cleanVideoArray = [];
        foreach ($this->video ?? [] as $key => $value) {
            if (!empty($value['video'])) {
                $cleanVideoArray[]['video'] = $value['video'];
            }
        }
        $this->merge([
            'video' => $cleanVideoArray,
        ]);

        if ($this->isMethod('post') || $this->has('slug')) {
            if ($str = $this->slug ?: $this->name) {
                $this->merge([
                    'slug' => Service::slugGenerate($str, $this->route('service')),
                ]);
            }
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
            'lang' => 'nullable',
            'main_photo' => 'nullable|mimes:jpeg,jpg,png',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phones' => 'array',
            'country' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'street' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'working' => 'nullable|array',
            'descr' => 'required|string',
            'service' => 'nullable|array',
            'video' => 'nullable|array',
            'video.*.video.*' => 'nullable|url',
            'social' => 'nullable|array',
            'social.*' => 'nullable|url',
            'slug' => 'sometimes|string',
            'status' => 'required|in:' . implode(',', array_keys(Service::statusesList())),
            'is_active' => 'required|boolean',
            'is_sitemap' => 'required|boolean',
            'msg_reject ' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
