<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMomProfileRequest extends FormRequest
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
        return [
            'name' => 'required',
            'phone' => 'required',
            'birth_date' => 'required|date_format:Y-m-d',
            'job' => 'required',
            'pregnancy_week' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'user.name.required' => 'EL nombre es obligatorio',
            'mom_profile.phone.required' => 'El teléfono es obligatorio',
            'mom_profile.birth_date.required' => 'La fecha de nacimiento es obligatoria',
            'mom_profile.job.required' => 'La ocupación es obligatoria',
            'mom_profile.pregnancy_week.required' => 'La semana de embarazo es obligatoria',
        ];
    }
}
