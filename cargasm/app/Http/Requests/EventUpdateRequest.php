<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventUpdateRequest extends FormRequest
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
            'lang' => 'nullable',
            'main_photo' => 'required',
            'photos' => 'nullable|array',
            'photos.*.file' => 'nullable|mimes:jpeg,jpg,png',
            'title' => 'required|string',
            'country' => 'required|string|max:255',
            'place' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            //            'coauthor.id' => 'nullable|exists:users,id',
            'category' => ['required', 'string', 'max:255', Rule::in(array_column(Event::categoryList(), 'value'))],
            'is_privacy' => ['required', 'string', 'max:255', Rule::in(array_column(Event::privacyList(), 'key'))],
            'confirm_user' => 'required|boolean',
            'descr' => 'required|string',
            'comment_allowed' => 'required|boolean',
            'chat_allowed' => 'required|boolean',
            'photos_allowed' => 'required|boolean',
            'count_seats' => 'nullable|numeric|max:1000000',
            'age' => ['nullable', Rule::requiredIf($this->get('is_privacy') === 'open'),  Rule::in(array_column(Event::ageList(), 'key'))],
            'sex' => ['nullable', Rule::requiredIf($this->get('is_privacy') === 'open'),  Rule::in(array_column(Event::genderList(), 'key'))],
            'dates' => 'required|array|min:1',
            'dates.*' => 'required|min:1',
            'dates.date.from' => 'required|min:1',
            'dates.date.to' => 'required|min:1',
            'dates.time.from' => 'required|min:1',
            'dates.time.to' => 'required|min:1',
            'self_schedule_dates' => 'nullable|boolean',
            'dates_continuous' => 'nullable|boolean',
            'more_days' => 'nullable|boolean',
            //            'author_type' => ['string', 'nullable', 'max:255', Rule::in(array_column(Event::authorTypeList(),'key'))],
            'external_source' => 'nullable|boolean',
            'external' => 'nullable|array',
            'external.name' => 'nullable|string',
            'external.link' => 'nullable|url',
            'self_schedule_dates' => 'nullable|boolean',
            'dates_continuous' => 'nullable|boolean',
            'more_days' => 'nullable|boolean',
        ];
    }
}
