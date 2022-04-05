<?php

namespace App\Http\Requests\Admin\OfficeUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateOfficeUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.office-user.edit', $this->officeUser);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['sometimes', 'string'],
            'office_id' => ['sometimes', 'string'],
            'deleted' => ['nullable', 'boolean'],

        ];
    }

    /**
     * Modify input data.
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
